<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\ProjectCategoryRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\Municipality;
use App\Models\Person;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Sentinel;

class ProjectController extends JoshController
{
    public function index()
    {
        $projects = Project::where('is_archive', false)->get();
        // Show the page
        return view('admin.projects.index', compact('projects'));
    }

    public function archive()
    {
        $projects = Project::where('is_archive', true)->get();
        // Show the page
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProjectCategory::all();
        $municipalities = Municipality::all();

        return view('admin.projects.create', compact('categories', 'municipalities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return
     */
    public function store(ProjectRequest $request)
    {
        DB::beginTransaction();
        try {
            Project::createProject(
                $request->title,
                $request->category_id,
                $request->short_description,
                $request->municipality_id,
                $request->picture,
                Sentinel::getUser()->id,
                $request->documents,
                $request->is_archive ? true : false,
                true,
                true,
                $request->date);
            DB::commit();
            return redirect()->route('admin.projects.index')->withSuccess('პროექტი წარმატებით დაემატა');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Admin\ProjectController->store::$request -> ".json_encode($request->all()) . ". \n\rMessage: ".$e->getMessage());
            return redirect()->back()->withInput()->withError('დაფიქსირდა შეცდომა პროექტის დამატების დროს');
        }
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Models\Project  $project
//     * @return \Illuminate\Http\Response
//     */
//    public function show(int $project)
//    {
//        $project = Project::findOrFail($project);
//
//        $user = Sentinel::getUser();
//
//        if((!$project->is_active_for_web && !$user) || (!$project->is_active_for_web && $user && $user->id !== $project->user_id)) {
//            return redirect()->to(url()->to('/best-practice'));
//        }
//
//        return view('projects.show', compact('project'));
//    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $project
     * @return Response
     */
    public function edit(int $project)
    {
        $categories = ProjectCategory::all();
        $municipalities = Municipality::all();
        $project = Project::findOrFail($project);

        return view('admin.projects.edit', compact('project', 'categories', 'municipalities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param int $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectRequest $request, int $project)
    {
        $project = Project::findOrFail($project);


        DB::beginTransaction();
        try {
            $project->updateProject(
                $request->title,
                $request->category_id,
                $request->short_description,
                $request->municipality_id,
                $request->picture,
                Sentinel::getUser()->id,
                $request->documents,
                $request->is_archive ? true : false,
                true,
                true,
                $request->date);
            DB::commit();
            return redirect('admin/projects')->with('success', 'პროექტი წარმატებით განახლდა');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Admin\ProjectController->update::$request -> ".json_encode($request->all()) . ". \n\rMessage: ".$e->getMessage());
            return redirect()->back()->withInput()->with('error', 'დაფიქსირდა შეცდომა პროექტის განახლების დროს');
        }
    }

    /**
     * Remove blog.
     *
     * @param int $project
     * @return Response
     */
    public function getModalDelete(int $project)
    {
        $model = 'project';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.projects.delete', ['id' => $project]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {
            $error = 'დაფიქსირდა შეცდომა პროექტის წაშლის დროს';
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $project)
    {
        $project = Project::findOrFail($project);

        if ($project->delete()) {
            return redirect('admin/projects')->with('success', 'პროექტის კატეგორია წარმატებით წაიშალა');
        } else {
            return Redirect::route('admin.projects.index')->withInput()->with('error', 'დაფიქსირდა შეცდომა პროექტის წაშლის დროს');
        }
    }

    public function deleteDocument(int $id) {
        try {
            $document = ProjectDocument::findOrFail($id);

            $document->delete();

            return redirect()->back()->with('success', 'დოკუმენტი წარმატებით წაიშალა');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'დაფიქსირდა შეცდომა დოკუმენტის წაშლის დროს');
        }
    }

    public function renameDocument(Request $request, int $id) {
        try {
            $document = ProjectDocument::findOrFail($id);

            $document->name = $request->get('name');
            $document->save();

            return redirect()->back()->with('success', 'დოკუმენტის სახელი წარმატებით შეიცვალა');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'დაფიქსირდა შეცდომა დოკუმენტის სახელის შეცვლის დროს');
        }
    }

    public function toggleDocumentVisibility(int $id) {
        try {
            $document = ProjectDocument::findOrFail($id);

            $document->is_visible = !$document->is_visible;

            $document->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'დაფიქსირდა შეცდომა');
        }
    }

    public function toggleActivationForWeb(int $id) {
        try {
            $project = Project::findOrFail($id);

            $project->is_active_for_web = !$project->is_active_for_web;

            $project->save();

            return redirect()->back()->with('success', 'პროექტს წარმატებით შეეცვალა სტატუსი');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'დაფიქსირდა შეცდომა');
        }
    }

    public function toggleActivationForExperts(int $id) {
        try {
            $project = Project::findOrFail($id);

            $project->is_active_for_experts = !$project->is_active_for_experts;

            $project->save();

            return redirect()->back()->with('success', 'პროექტს წარმატებით შეეცვალა სტატუსი');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'დაფიქსირდა შეცდომა');
        }
    }

    public function toggleIsArchive(int $id) {
        try {
            $project = Project::findOrFail($id);

            if($project->is_archive) {
                $message = 'პროექტს წარმატებით გაუუქმდა არქივის სტატუსი';
                $project->is_archive = false;
            } else {
                $message = 'პროექტი წარმატებით გადავიდა აქრივში';
                $project->is_archive = true;
            }

            $project->save();

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'დაფიქსირდა შეცდომა');
        }
    }

    public function deleteEvaluation(int $id) {
        try {
            $project = Project::with('evaluations')->where('id', $id)->firstOrFail();

            $project->rating_points = null;
            $project->save();

            foreach ($project->evaluations as $evaluation) {
                $evaluation->subEvaluations()->delete();
            }

            $project->evaluations()->delete();

            return redirect()->route('projects.show', $id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'დაფიქსირდა შეცდომა შეფასების წაშლის დროს. '.$e->getMessage());
        }
    }
}
