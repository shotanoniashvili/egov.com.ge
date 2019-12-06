<?php

use Illuminate\Support\Facades\Artisan;

include_once 'web_builder.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('migrate', function () {
    Artisan::call('migrate');
});
Route::get('migrate/rollback', function () {
    Artisan::call('migrate:rollback');
});
Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:cache');
    Artisan::call('route:cache');
});

Route::pattern('slug', '[a-z0-9- _]+');

Route::group(['middleware' => 'expert'], function() {
    Route::get('my-account/evaluated', 'ProjectController@showEvaluatedProjects')->name('my-account.show-evaluated-projects');
    Route::get('my-account/to-evaluate', 'ProjectController@showProjectsToEvaluate')->name('my-account.show-projects-to-evaluate');
    Route::get('projects/{id}/evaluate', 'ProjectController@showEvaluateForm')->name('projects.evaluate');
    Route::post('projects/{id}/evaluate', 'ProjectController@evaluate');
    Route::get('projects/{id}/rating', 'ProjectController@rating')->name('projects.rating');
});

Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {

    # Error pages should be shown without requiring login
    Route::get('404', function () {
        return view('admin/404');
    });
    Route::get('500', function () {
        return view('admin/500');
    });
    # Lock screen
    Route::get('{id}/lockscreen', 'UsersController@lockscreen')->name('lockscreen');
    Route::post('{id}/lockscreen', 'UsersController@postLockscreen')->name('lockscreen');
    # All basic routes defined here
    Route::get('login', 'AuthController@getSignin')->name('login');
    Route::get('signin', 'AuthController@getSignin')->name('signin');
    Route::post('signin', 'AuthController@postSignin')->name('postSignin');
    Route::post('signup', 'AuthController@postSignup')->name('admin.signup');
    Route::post('forgot-password', 'AuthController@postForgotPassword')->name('forgot-password');
    Route::get('login2', function () {
        return view('admin/login2');
    });


    # Register2
    Route::get('register2', function () {
        return view('admin/register2');
    });
    Route::post('register2', 'AuthController@postRegister2')->name('register2');

    # Forgot Password Confirmation
//    Route::get('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm')->name('forgot-password-confirm');
//    Route::post('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm');

    # Logout
    Route::get('logout', 'AuthController@getLogout')->name('logout');

    # Account Activation
    Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate')->name('activate');
});


Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    # GUI Crud Generator
    Route::get('generator_builder', 'JoshController@builder')->name('generator_builder');
    Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
    Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');
    // Model checking
    Route::post('modelCheck', 'ModelcheckController@modelCheck');

    # Dashboard / Index
//    Route::get('/', 'JoshController@showHome')->name('dashboard');
    Route::get('/', function() {
        return redirect()->route('admin.projects.index');
    })->name('dashboard');

    # crop demo
    Route::post('crop_demo', 'JoshController@cropDemo')->name('crop_demo');
    //Log viewer routes
    Route::get('log_viewers', 'Admin\LogViewerController@index')->name('log-viewers');
    Route::get('log_viewers/logs', 'Admin\LogViewerController@listLogs')->name('log_viewers.logs');
    Route::delete('log_viewers/logs/delete', 'Admin\LogViewerController@delete')->name('log_viewers.logs.delete');
    Route::get('log_viewers/logs/{date}', 'Admin\LogViewerController@show')->name('log_viewers.logs.show');
    Route::get('log_viewers/logs/{date}/download', 'Admin\LogViewerController@download')->name('log_viewers.logs.download');
    Route::get('log_viewers/logs/{date}/{level}', 'Admin\LogViewerController@showByLevel')->name('log_viewers.logs.filter');
    Route::get('log_viewers/logs/{date}/{level}/search', 'Admin\LogViewerController@search')->name('log_viewers.logs.search');
    Route::get('log_viewers/logcheck', 'Admin\LogViewerController@logCheck')->name('log-viewers.logcheck');
    //end Log viewer
    # Activity log
    Route::get('activity_log/data', 'JoshController@activityLogData')->name('activity_log.data');
//    Route::get('/', 'JoshController@index')->name('index');
});

Route::group(['prefix' => 'admin','namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {

    # User Management
    Route::group([ 'prefix' => 'users'], function () {
        Route::get('data/{role?}', 'UsersController@data')->name('users.data');
        Route::get('{user}/delete', 'UsersController@destroy')->name('users.delete');
        Route::get('{user}/confirm-delete', 'UsersController@getModalDelete')->name('users.confirm-delete');
        Route::get('{user}/restore', 'UsersController@getRestore')->name('restore.user');
//        Route::post('{user}/passwordreset', 'UsersController@passwordreset')->name('passwordreset');
        Route::post('passwordreset', 'UsersController@passwordreset')->name('passwordreset');
    });
    Route::resource('users', 'UsersController');

    /************ bulk import ****************************/
    Route::get('bulk_import_users', 'UsersController@import');
    Route::post('bulk_import_users', 'UsersController@importInsert');
    /****************bulk download **************************/
    Route::get('download_users/{type}', 'UsersController@downloadExcel');





    Route::get('deleted_users',['before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'])->name('deleted_users');

    // Email System
    Route::group(['prefix' => 'emails'], function () {
        Route::get('compose', 'EmailController@create');
        Route::post('compose', 'EmailController@store');
        Route::get('inbox', 'EmailController@inbox');
        Route::get('sent', 'EmailController@sent');
        Route::get('{email}', ['as' => 'emails.show', 'uses' => 'EmailController@show']);
        Route::get('{email}/reply', ['as' => 'emails.reply', 'uses' => 'EmailController@reply']);
        Route::get('{email}/forward', ['as' => 'emails.forward', 'uses' => 'EmailController@forward']);
    });
    Route::resource('emails', 'EmailController');

    # Group Management
    Route::group(['prefix' => 'roles'], function () {
        Route::get('{group}/delete', 'RolesController@destroy')->name('roles.delete');
        Route::get('{group}/confirm-delete', 'RolesController@getModalDelete')->name('roles.confirm-delete');
        Route::get('{group}/restore', 'RolesController@getRestore')->name('roles.restore');
    });
    Route::resource('roles', 'RolesController');

    /*routes for blog*/
    Route::group(['prefix' => 'blog'], function () {
        Route::get('{blog}/delete', 'BlogController@destroy')->name('blog.delete');
        Route::get('{blog}/confirm-delete', 'BlogController@getModalDelete')->name('blog.confirm-delete');
        Route::get('{blog}/restore', 'BlogController@restore')->name('blog.restore');
        Route::post('{blog}/storecomment', 'BlogController@storeComment')->name('storeComment');
    });
    Route::resource('blog', 'BlogController');

    /*routes for blog category*/
    Route::group(['prefix' => 'blogcategory'], function () {
        Route::get('{blogCategory}/delete', 'BlogCategoryController@destroy')->name('blogcategory.delete');
        Route::get('{blogCategory}/confirm-delete', 'BlogCategoryController@getModalDelete')->name('blogcategory.confirm-delete');
        Route::get('{blogCategory}/restore', 'BlogCategoryController@getRestore')->name('blogcategory.restore');
    });

    Route::resource('blogcategory', 'BlogCategoryController');

    /*routes for project category*/
    Route::group(['prefix' => 'project-categories'], function () {
        Route::get('{projectCategory}/delete', 'ProjectCategoryController@destroy')->name('project-categories.delete');
        Route::get('{projectCategory}/confirm-delete', 'ProjectCategoryController@getModalDelete')->name('project-categories.confirm-delete');
        Route::get('{projectCategory}/restore', 'ProjectCategoryController@getRestore')->name('project-categories.restore');
    });
    Route::resource('project-categories', 'ProjectCategoryController');

    /*routes for faq*/
    Route::group(['prefix' => 'faq'], function () {
        Route::get('{faq}/delete', 'FaqController@destroy')->name('faq.delete');
        Route::get('{faq}/confirm-delete', 'FaqController@getModalDelete')->name('faq.confirm-delete');
        Route::get('{faq}/restore', 'FaqController@getRestore')->name('faq.restore');
    });
    Route::resource('faq', 'FaqController');

    /*routes for projects in admin panel*/
    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', 'ProjectController@index')->name('projects.index');
        Route::get('archive', 'ProjectController@archive')->name('projects.archive');
        Route::get('create', 'ProjectController@create')->name('projects.create');
        Route::post('create', 'ProjectController@store')->name('projects.store');
        Route::patch('edit/{project}', 'ProjectController@update')->name('projects.update');
        Route::get('edit/{project}', 'ProjectController@edit')->name('projects.edit');
        Route::get('delete/{project}', 'ProjectController@destroy')->name('projects.delete');
        Route::get('confirm-delete/{project}', 'ProjectController@getModalDelete')->name('projects.confirm-delete');
        Route::get('documents/{id}/delete', 'ProjectController@deleteDocument')->name('projects.delete-document');
        Route::get('documents/{id}/toggle-visibility', 'ProjectController@toggleDocumentVisibility')->name('projects.toggle-document-visibility');
        Route::patch('documents/{id}', 'ProjectController@renameDocument')->name('projects.rename-document');
        Route::get('toggle/is-best-practise/{id}', 'ProjectController@toggleBestPractise')->name('projects.toggle-is-best-practise');
        Route::get('toggle/is-archive/{id}', 'ProjectController@toggleIsArchive')->name('projects.toggle-is-archive');
        Route::get('toggle/is-active-for-web/{id}', 'ProjectController@toggleActivationForWeb')->name('projects.toggle-activation-for-web');
        Route::get('toggle/is-active-for-experts/{id}', 'ProjectController@toggleActivationForExperts')->name('projects.toggle-activation-for-experts');

        Route::get('rating/{id}', '\App\Http\Controllers\ProjectController@rating')->name('projects.rating');
        Route::get('rating/{id}/delete', 'ProjectController@deleteEvaluation')->name('projects.delete-evaluation');
    });


    /*rates in admin panel*/
    Route::group(['prefix' => 'rates'], function () {
        Route::get('/', 'RatesController@index')->name('rates.index');
        Route::get('/create', 'RatesController@create')->name('rates.create');
        Route::post('/create', 'RatesController@store');
        Route::get('/{id}/edit', 'RatesController@edit')->name('rates.edit');
        Route::patch('/{id}/edit', 'RatesController@update');
        Route::get('/{id}/json', 'RatesController@getRate')->name('rates.getJson');
        Route::get('/{id}/delete', 'RatesController@destroy');
    });

    /*routes for regions */
    Route::group(['prefix' => 'regions'], function () {
        Route::get('{region}/delete', 'RegionController@destroy')->name('regions.delete');
        Route::get('{region}/confirm-delete', 'RegionController@getModalDelete')->name('regions.confirm-delete');
        Route::get('{region}/restore', 'RegionController@getRestore')->name('regions.restore');
    });
    Route::resource('regions', 'RegionController');

    /*routes for municipalities*/
    Route::group(['prefix' => 'municipalities'], function () {
        Route::get('{municipality}/delete', 'MunicipalityController@destroy')->name('municipalities.delete');
        Route::get('{municipality}/confirm-delete', 'MunicipalityController@getModalDelete')->name('municipalities.confirm-delete');
        Route::get('{municipality}/restore', 'MunicipalityController@getRestore')->name('municipalities.restore');
    });
    Route::resource('municipalities', 'MunicipalityController');

    /*routes for file*/
    Route::group(['prefix' => 'file'], function () {
        Route::post('create', 'FileController@store')->name('store');
        Route::post('createmulti', 'FileController@postFilesCreate')->name('postFilesCreate');
//        Route::delete('delete', 'FileController@delete')->name('delete');
        Route::get('{id}/delete', 'FileController@destroy')->name('file.delete');
        Route::get('data', 'FileController@data')->name('file.data');
        Route::get('{user}/delete', 'FileController@destroy')->name('users.delete');
    });

    /*routes for News*/
    Route::group(['prefix' => 'news'], function () {
        Route::get('data', 'NewsController@data')->name('news.data');
        Route::get('{news}/delete', 'NewsController@destroy')->name('news.delete');
        Route::get('{news}/confirm-delete', 'NewsController@getModalDelete')->name('news.confirm-delete');

        Route::get('toggle/is-draft/{id}', 'NewsController@toggleIsDraft')->name('news.toggle-is-draft');
    });
    Route::resource('news', 'NewsController');

    Route::get('crop_demo', function () {
        return redirect('admin/imagecropping');
    });


    /* laravel example routes */
    #Charts
    Route::get('laravel_chart', 'ChartsController@index')->name('laravel_chart');
    Route::get('database_chart', 'ChartsController@databaseCharts')->name('database_chart');

    # datatables
    Route::get('datatables', 'DataTablesController@index')->name('index');
    Route::get('datatables/data', 'DataTablesController@data')->name('datatables.data');

    # datatables
    Route::get('jtable/index', 'JtableController@index')->name('index');
    Route::post('jtable/store', 'JtableController@store')->name('store');
    Route::post('jtable/update', 'JtableController@update')->name('update');
    Route::post('jtable/delete', 'JtableController@destroy')->name('delete');



    # SelectFilter
    Route::get('selectfilter', 'SelectFilterController@index')->name('selectfilter');
    Route::get('selectfilter/find', 'SelectFilterController@filter')->name('selectfilter.find');
    Route::post('selectfilter/store', 'SelectFilterController@store')->name('selectfilter.store');

    # editable datatables
    Route::get('editable_datatables', 'EditableDataTablesController@index')->name('index');
    Route::get('editable_datatables/data', 'EditableDataTablesController@data')->name('editable_datatables.data');
    Route::post('editable_datatables/create', 'EditableDataTablesController@store')->name('store');
    Route::post('editable_datatables/{id}/update', 'EditableDataTablesController@update')->name('update');
    Route::get('editable_datatables/{id}/delete', 'EditableDataTablesController@destroy')->name('editable_datatables.delete');

//    # custom datatables
    Route::get('custom_datatables', 'CustomDataTablesController@index')->name('index');
    Route::get('custom_datatables/sliderData', 'CustomDataTablesController@sliderData')->name('custom_datatables.sliderData');
    Route::get('custom_datatables/radioData', 'CustomDataTablesController@radioData')->name('custom_datatables.radioData');
    Route::get('custom_datatables/selectData', 'CustomDataTablesController@selectData')->name('custom_datatables.selectData');
    Route::get('custom_datatables/buttonData', 'CustomDataTablesController@buttonData')->name('custom_datatables.buttonData');
    Route::get('custom_datatables/totalData', 'CustomDataTablesController@totalData')->name('custom_datatables.totalData');

    //tasks section
    Route::post('task/create', 'TaskController@store')->name('store');
    Route::get('task/data', 'TaskController@data')->name('data');
    Route::post('task/{task}/edit', 'TaskController@update')->name('update');
    Route::post('task/{task}/delete', 'TaskController@delete')->name('delete');
});



# Remaining pages will be called from below controller method
# in real world scenario, you may be required to define all routes manually

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('{name?}', 'JoshController@showView');
});

#FrontEndController
Route::get('login', 'FrontEndController@getLogin')->name('login');
Route::post('login', 'FrontEndController@postLogin')->name('login');
Route::get('register', 'FrontEndController@getRegister')->name('register');
Route::post('register','FrontEndController@postRegister')->name('register');
Route::get('activate/{userId}/{activationCode}','FrontEndController@getActivate')->name('activate');
Route::get('forgot-password','FrontEndController@getForgotPassword')->name('forgot-password');
Route::post('forgot-password', 'FrontEndController@postForgotPassword');

#Projects
Route::get('best-practice', 'ProjectController@bestPractice')->name('projects.best-practice');
Route::get('archive', 'ProjectController@archive')->name('projects.archive');
Route::get('projects/{project}', 'ProjectController@show')->name('projects.show');

#Municipalities
Route::get('municipalities', 'MunicipalityController@index')->name('municipalities.index');
Route::get('municipalities/{municipality}', 'MunicipalityController@show')->name('municipalities.show');

#Social Logins
Route::get('facebook', 'Admin\FacebookAuthController@redirectToProvider');
Route::get('facebook/callback', 'Admin\FacebookAuthController@handleProviderCallback');

Route::get('linkedin', 'Admin\LinkedinAuthController@redirectToProvider');
Route::get('linkedin/callback', 'Admin\LinkedinAuthController@handleProviderCallback');

Route::get('google', 'Admin\GoogleAuthController@redirectToProvider');
Route::get('google/callback', 'Admin\GoogleAuthController@handleProviderCallback');


# Forgot Password Confirmation
Route::post('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');
Route::get('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@getForgotPasswordConfirm')->name('forgot-password-confirm');
# My account display and update details
Route::group(['middleware' => 'user'], function () {
    Route::put('my-account', 'FrontEndController@update');
    Route::get('my-account', 'FrontEndController@myAccount')->name('my-account');
    Route::get('my-account/uploaded-projects', 'FrontEndController@uploadedProjects')->name('my-account.uploaded');
    Route::get('my-account/upload-project', 'FrontEndController@showUploadForm')->name('my-account.upload');
    Route::post('my-account/upload-project', 'ProjectController@store');
});
// Email System
Route::group(['prefix' => 'user_emails'], function () {
    Route::get('compose', 'UsersEmailController@create');
    Route::post('compose', 'UsersEmailController@store');
    Route::get('inbox', 'UsersEmailController@inbox');
    Route::get('sent', 'UsersEmailController@sent');
    Route::get('{email}', ['as' => 'user_emails.show', 'uses' => 'UsersEmailController@show']);
    Route::get('{email}/reply', ['as' => 'user_emails.reply', 'uses' => 'UsersEmailController@reply']);
    Route::get('{email}/forward', ['as' => 'user_emails.forward', 'uses' => 'UsersEmailController@forward']);
});
Route::resource('user_emails', 'UsersEmailController');
Route::get('logout', 'FrontEndController@getLogout')->name('logout');
# contact form
Route::post('contact', 'FrontEndController@postContact')->name('contact');

#frontend views
Route::get('/', ['as' => 'home', function () {
    return view('index');
}]);

Route::get('blog','BlogController@index')->name('blog');
Route::get('blog/{slug}/tag', 'BlogController@getBlogTag');
Route::get('blogitem/{slug?}', 'BlogController@getBlog');
Route::post('blogitem/{blog}/comment', 'BlogController@storeComment');

//news
Route::get('news', 'NewsController@index')->name('news');
Route::get('news/{news}', 'NewsController@show')->name('news.show');

Route::get('search', 'FrontEndController@search')->name('search');

Route::get('{name?}', 'FrontEndController@showFrontEndView');
# End of frontend views
