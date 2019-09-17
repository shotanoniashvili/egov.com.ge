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
                true,
                true,
                true,
                $request->project_date);
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
        $project = Project::findOrFail($project);

        // TODO view

        return view('admin.project.edit', compact('project'));
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
        $project = ProjectCategory::findOrFail($project);

        // TODO update

        if ($project->update($request->all())) {
            return redirect('admin/projects')->with('success', 'პროექტი წარმატებით განახლდა');
        } else {
            return Redirect::route('admin/project-categories')->withInput()->with('error', 'დაფიქსირდა შეცდომა პროექტის განახლების დროს');
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

        $project->documents()->delete();

        if ($project->delete()) {
            return redirect('admin/projects')->with('success', 'პროექტის კატეგორია წარმატებით წაიშალა');
        } else {
            return Redirect::route('admin/projects')->withInput()->with('error', 'დაფიქსირდა შეცდომა პროექტის წაშლის დროს');
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
}
