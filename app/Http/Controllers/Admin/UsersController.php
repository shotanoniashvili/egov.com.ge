<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\UserRequest;
use App\Mail\Register;
use App\Models\Municipality;
use App\Models\ProjectCategory;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Redirect;
use Sentinel;
use URL;
use View;
use Yajra\DataTables\DataTables;
use Validator;
use App\Mail\Restore;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends JoshController
{

    /**
     * Show a list of all the users.
     *
     * @return View
     */
    private $user_activation = false;

    public function index(string $role = '')
    {
        $users = User::query();

        if($role = 'experts') {
            $users->whereHas('roles', function($query) {
                $query->where('name', 'expert');
            });
        }

        if($role = 'users') {
            $users->whereHas('roles', function($query) {
                $query->where('name', 'user');
            });
        }

        $users = $users->get();

        // Show the page
        return view('admin.users.index', compact('users'));
    }

    /*
     * Pass data through ajax call
     */
    /**
     * @param string $role
     * @return mixed
     * @throws \Exception
     */
    public function data($role = '')
    {
        $users = User::query();

        if($role == 'experts') {
            $users->whereHas('roles', function($query) {
                $query->where('slug', 'expert');
            });
        }

        if($role == 'users') {
            $users->whereHas('roles', function($query) {
                $query->where('slug', 'user');
            });
        }
        $users = $users->get(['id', 'first_name', 'last_name', 'email','created_at']);

        return DataTables::of($users)
            ->editColumn(
                'created_at',
                function (User $user) {
                    return $user->created_at->diffForHumans();
                }
            )
            ->addColumn(
                'status',
                function ($user) {

                    if ($activation = Activation::completed($user)) {
                        return 'Activated';
                    } else {
                                        return 'Pending';
                    }
                }
            )
            ->addColumn(
                'actions',
                function ($user) {
                    $actions = '<a href='. route('admin.users.show', $user->id) .'><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="view user"></i></a>
                            <a href='. route('admin.users.edit', $user->id) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update user"></i></a>';
                    if ((Sentinel::getUser()->id != $user->id) && ($user->id >2)) {
                        $actions .= '<a href='. route('admin.users.confirm-delete', $user->id) .' data-id="'.$user->id.'" data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="user-remove" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete user"></i></a>';
                    }
                    return $actions;
                }
            )
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Create new user
     *
     * @return View
     */
    public function create()
    {
        // Get all the available groups
        $groups = Sentinel::getRoleRepository()->all();

        $countries = $this->countries;

        $projectCategories = ProjectCategory::all();
        $municipalities = Municipality::all();
        // Show the page
        return view('admin.users.create', compact('groups', 'countries', 'projectCategories', 'municipalities'));
    }

    /**
     * User create form processing.
     *
     * @return Redirect
     */
    public function store(UserRequest $request)
    {
        //check whether use should be activated by default or not
        $activate = $request->get('activate') ? true : false;

        try {
            // Register the user
            $user = Sentinel::register($request->except('_token', 'password_confirm', 'group', 'activate', 'pic_file', 'g-recaptcha-response', 'project_category_ids', 'municipality_ids'), $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleById($request->get('group'));
            if ($role) {
                $role->users()->attach($user);
            }
            //check for activation and send activation mail if not activated by default
            if (!$request->get('activate')) {
                // Data to be used on the email view
                $data =[
                    'user_name' => $user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code])
                ];
                // Send the activation code through email
                Mail::to($user->email)
                    ->send(new Register($data));
            }

            if($request->get('project_category_ids')) {
                $user->categories()->sync($request->get('project_category_ids'));
            }

            if($request->get('municipality_ids')) {
                $user->municipalities()->sync($request->get('municipality_ids'));
            }

            // Activity log for New user create
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('New User Created by '.Sentinel::getUser()->full_name);
            // Redirect to the home page with success menu
            return Redirect::route('admin.users.index')->with('success', trans('users/message.success.create'));
        } catch (LoginRequiredException $e) {
            $error = trans('admin/users/message.user_login_required');
        } catch (PasswordRequiredException $e) {
            $error = trans('admin/users/message.user_password_required');
        } catch (UserExistsException $e) {
            $error = trans('admin/users/message.user_exists');
        }

        // Redirect to the user creation page
        return Redirect::back()->withInput()->with('error', $error);
    }

    /**
     * User update.
     *
     * @param  int $id
     * @return View
     */
    public function edit(int $id)
    {
        $targetUser = User::findOrFail($id);

        // Get this user groups
        $userRoles = $targetUser->getRoles()->pluck('name', 'id')->all();
        // Get a list of all the available groups
        $groups = Sentinel::getRoleRepository()->all();

        $status = Activation::completed($targetUser);

        $countries = $this->countries;

        $projectCategories = ProjectCategory::all();
        $municipalities = Municipality::all();

        $isActive = Activation::completed($targetUser)->completed;

        // Show the page
        return view('admin.users.edit', compact('targetUser', 'groups', 'userRoles', 'countries', 'status', 'projectCategories', 'municipalities', 'isActive'));
    }

    /**
     * User update form processing page.
     *
     * @param  User        $user
     * @param  UserRequest $request
     * @return Redirect
     */
    public function update(User $user, UserRequest $request)
    {


        try {
            $user->update($request->except('pic_file', 'password', 'password_confirm', 'group', 'activate', 'project_category_ids', 'municipality_ids'));

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            if($request->get('project_category_ids')) {
                $user->categories()->sync($request->get('project_category_ids'));
            }

            if($request->get('municipality_ids')) {
                $user->municipalities()->sync($request->get('municipality_ids'));
            }

            //save record
            $user->save();

            $user->roles()->sync([$request->group]);

            // Activate / De-activate user

            $status = $activation = Activation::completed($user);

            if ($request->get('activate') != $status) {
                if ($request->get('activate')) {
                    $activation = Activation::exists($user);
                    if ($activation) {
                        Activation::complete($user, $activation->code);
                    }
                } else {
                    //remove existing activation record
                    Activation::remove($user);
                    //add new record
                    Activation::create($user);
                    //send activation mail
                    $data=[
                        'user_name' =>$user->first_name .' '. $user->last_name,
                    'activationUrl' => URL::route('activate', [$user->id, Activation::exists($user)->code])
                    ];
                    // Send the activation code through email
                    Mail::to($user->email)
                        ->send(new Restore($data));
                }
            }

            // Was the user updated?
            if ($user->save()) {
                // Prepare the success message
                $success = trans('users/message.success.update');
                //Activity log for user update
                activity($user->full_name)
                    ->performedOn($user)
                    ->causedBy($user)
                    ->log('User Updated by '.Sentinel::getUser()->full_name);
                // Redirect to the user page
                return Redirect::route('admin.users.edit', $user)->with('success', $success);
            }

            // Prepare the error message
            $error = trans('users/message.error.update');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }

        // Redirect to the user page
        return Redirect::route('admin.users.edit', $user)->withInput()->with('error', $error);
    }

    /**
     * Show a list of all the deleted users.
     *
     * @return View
     */
    public function getDeletedUsers()
    {
        // Grab deleted users
        $users = User::onlyTrashed()->get();

        // Show the page
        return view('admin.deleted_users', compact('users'));
    }


    /**
     * Delete Confirm
     *
     * @param  int $id
     * @return View
     */
    public function getModalDelete($id)
    {
        $model = 'users';
        $confirm_route = $error = null;
        try {
            // Get user information
            $user = Sentinel::findById($id);

            // Check if we are not trying to delete ourselves
            if ($user->id === Sentinel::getUser()->id) {
                // Prepare the error message
                $error = trans('users/message.error.delete');

                return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
        $confirm_route = route('admin.users.delete', ['id' => $user->id]);
        return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
    }

    /**
     * Delete the given user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function destroy($id)
    {
        try {
            // Get user information
            $user = Sentinel::findById($id);
            // Check if we are not trying to delete ourselves
            if ($user->id === Sentinel::getUser()->id) {
                // Prepare the error message
                $error = trans('admin/users/message.error.delete');
                // Redirect to the user management page
                return Redirect::route('admin.users.index')->with('error', $error);
            }
            // Delete the user
            //to allow soft deleted, we are performing query on users model instead of Sentinel model
            User::destroy($id);
            Activation::where('user_id', $user->id)->delete();
            // Prepare the success message
            $success = trans('users/message.success.delete');
            //Activity log for user delete
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('User deleted by '.Sentinel::getUser()->full_name);
            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }
    }

    /**
     * Restore a deleted user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function getRestore($id)
    {
        try {
            // Get user information
            $user = User::withTrashed()->find($id);
            // Restore the user
            $user->restore();
            // create activation record for user and send mail with activation link
            //            $data->user_name = $user->first_name .' '. $user->last_name;
            //            $data->activationUrl = URL::route('activate', [$user->id, Activation::create($user)->code]);
            // Send the activation code through email
            $data=[
               'user_name' => $user->first_name .' '. $user->last_name,
            'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code])
            ];
            Mail::to($user->email)
                ->send(new Restore($data));
            // Prepare the success message
            $success = trans('users/message.success.restored');
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('User restored by '.Sentinel::getUser()->full_name);
            // Redirect to the user management page
            return Redirect::route('admin.deleted_users')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('admin.deleted_users')->with('error', $error);
        }
    }

    /**
     * Display specified user profile.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            // Get the user information
            $user = Sentinel::findUserById($id);
            //get country name
            if ($user->country) {
                $user->country = $this->countries[$user->country];
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return Redirect::route('admin.users.index')->with('error', $error);
        }
        // Show the page
        return view('admin.users.show', compact('user'));
    }

    public function passwordreset(Request $request)
    {
        $id = $request->id;
        $user = Sentinel::findUserById($id);
        $password = $request->get('password');
        $user->password = Hash::make($password);
        $user->save();
    }

    public function lockscreen($id)
    {

        if (Sentinel::check()) {
            $user = Sentinel::findUserById($id);
            return view('admin.lockscreen', compact('user'));
        }
        return view('admin.login');
    }

    public function postLockscreen(Request $request)
    {
        $password = Sentinel::getUser()->password;
        if (Hash::check($request->password, $password)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function import()
    {
        return view('admin/users/import_users');
    }
    public function downloadExcel($type)
    {
        return response()->download(base_path('resources/excel-templates/users.xlsx'));
    }

    public function importInsert(Request $request)
    {
        if ($request->hasFile('import_file')) {
            $activate = $this->user_activation;
            $path = $request->file('import_file')->getRealPath();
            $users = Excel::selectSheets('users')->load(
                $path,
                function ($reader) {
                }
            )->get();
            if (! empty($users) && $users->count()) {
                foreach ($users->toArray() as $key => $row) {
                    $my_data = [
                      'email' => $row['email'],
                       'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                         'password' => $row['password'],
                    ];
                    $validator = Validator::make(
                        $my_data,
                        [
                         'email' => 'email',
                         'first_name' => 'required|min:3',
                         'last_name' => 'required|min:3',
                         'password' => 'required|min:3'
                         ]
                    );
                    if (isset($row['first_name']) && trim($row['first_name']) !="" && !$validator->fails()) {
                        $selected_user = User::where(
                            [
                                ['email' , $row['email']]
                            ]
                        )->first();

                        if ($selected_user) {
                            $user = $selected_user->update(
                                [
                                'email'         => $row['email'],
                                'first_name'         => $row['first_name'],
                                'last_name'            => $row['last_name'],
                                'password'            => Hash::make($row['password']),
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                                ]
                            );

                            activity($selected_user->full_name)
                            ->performedOn($selected_user)
                            ->causedBy($selected_user)
                            ->log('User Updated by '.Sentinel::getUser()->full_name);
                        } else {
                            $user = Sentinel::register(
                                [
                                'email'         => $row['email'],
                                'first_name'         => $row['first_name'],
                                'last_name'            => $row['last_name'],
                                'password'            => Hash::make($row['password']),
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                                ],
                                $activate
                            );

                              activity($user->full_name)
                            ->performedOn($user)
                            ->causedBy($user)
                            ->log('User Registered by '.Sentinel::getUser()->full_name);
                            // login user automatically
                            $role = Sentinel::findRoleById(2);
                            //add user to 'User' group

                            $role->users()->attach($user);
                            if (!$activate) {
                                // Data to be used on the email view

                                $data=[
                                    'user_name' => $user->first_name .' '. $user->last_name,
                                    'activationUrl' => URL::route('activate', [$user->id, Activation::create($user)->code]),
                                ];
                                // Send the activation code through email
                                Mail::to($user->email)->send(new Register($data));
                            }
                        }
                    }
                }

                return back()->with('success', 'Inserted Record Successfully');
            }
        }
        return back()->with('error', 'Please Check your file, Something is wrong there.');
    }
}
