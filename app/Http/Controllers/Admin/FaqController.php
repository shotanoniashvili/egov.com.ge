<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class FaqController extends JoshController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Grab all the blog category
        $faqs = Faq::all();
        // Show the page
        return view('admin.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FaqRequest $request)
    {
        $faq = new Faq($request->all());

        if ($faq->save()) {
            return redirect('admin/faq')->with('success', 'კითხვა-პასუხი წარმატებით დაემატა');
        } else {
            return Redirect::route('admin/faq')->withInput()->with('error', 'დაფიქსირდა შეცდომა კითხვა-პასუხის დროს');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProjectCategory $projectcategory
     * @return Response
     */
    public function edit(int $faq)
    {
        $faq = Faq::findOrFail($faq);

        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectCategoryRequest $request
     * @param ProjectCategory $projectcategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FaqRequest $request, int $faq)
    {
        $faq = Faq::findOrFail($faq);

        if ($faq->update($request->all())) {
            return redirect('admin/faq')->with('success', 'კითხვა-პასუხი წარმატებით განახლდა');
        } else {
            return Redirect::route('admin/faq')->withInput()->with('error', 'დაფიქსირდა შეცდომა კითხვა-პასუხის განახლების დროს');
        }
    }

    /**
     * Remove blog.
     *
     * @param int $projectCategory
     * @return Response
     */
    public function getModalDelete(int $faq)
    {
        $model = 'faq';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.faq.delete', ['id' => $faq]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {
            $error = 'დაფიქსირდა შეცდომა კითხვა-პასუხის წაშლის დროს';
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $projectCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $faq)
    {
        $faq = Faq::findOrFail($faq);

        if ($faq->delete()) {
            return redirect('admin/faq')->with('success', 'კითხვა-პასუხი წარმატებით წაიშალა');
        } else {
            return Redirect::route('admin/faq')->withInput()->with('error', 'დაფიქსირდა შეცდომა კითხვა-პასუხის წაშლის დროს');
        }
    }
}
