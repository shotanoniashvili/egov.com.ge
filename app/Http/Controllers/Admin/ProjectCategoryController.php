<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\ProjectCategoryRequest;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ProjectCategoryController extends JoshController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Grab all the blog category
        $projectcategories = ProjectCategory::all();
        // Show the page
        return view('admin.projectcategory.index', compact('projectcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.projectcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectCategoryRequest $request)
    {
        $projectCategory = new ProjectCategory($request->all());

        if ($projectCategory->save()) {
            return redirect('admin/project-categories')->with('success', 'კატეგორია წარმატებით დაემატა');
        } else {
            return redirect('admin/project-categories')->withInput()->with('error', 'დაფიქსირდა შეცდომა კატეგორიის დამატების დროს');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProjectCategory $projectcategory
     * @return Response
     */
    public function edit(int $projectcategory)
    {
        $projectcategory = ProjectCategory::findOrFail($projectcategory);

        return view('admin.projectcategory.edit', compact('projectcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectCategoryRequest $request
     * @param ProjectCategory $projectcategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectCategoryRequest $request, int $projectcategory)
    {
        $projectcategory = ProjectCategory::findOrFail($projectcategory);

        if ($projectcategory->update($request->all())) {
            return redirect('admin/project-categories')->with('success', 'კატეგორია წარმატებით განახლდა');
        } else {
            return Redirect::route('admin/project-categories')->withInput()->with('error', 'დაფიქსირდა შეცდომა კატეგორიის განახლების დროს');
        }
    }

    /**
     * Remove blog.
     *
     * @param int $projectCategory
     * @return Response
     */
    public function getModalDelete(int $projectCategory)
    {
        $model = 'projectcategory';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.project-categories.delete', ['id' => $projectCategory]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {
            $error = 'დაფიქსირდა შეცდომა პროექტის კატეგორიის წაშლის დროს';
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $projectCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $projectCategory)
    {
        $projectCategory = ProjectCategory::findOrFail($projectCategory);

        if ($projectCategory->delete()) {
            return redirect('admin/project-categories')->with('success', 'პროექტის კატეგორია წარმატებით წაიშალა');
        } else {
            return Redirect::route('admin/project-categories')->withInput()->with('error', 'დაფიქსირდა შეცდომა პროექტის კატეგორიის წაშლის დროს');
        }
    }
}
