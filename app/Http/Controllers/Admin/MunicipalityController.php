<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\MunicipalityRequest;
use App\Models\Municipality;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class MunicipalityController extends JoshController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Grab all the blog category
        $municipalities = Municipality::all();
        // Show the page
        return view('admin.municipalities.index', compact('municipalities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.municipalities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MunicipalityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MunicipalityRequest $request)
    {
        $municipality = new Municipality($request->all());

        if ($municipality->save()) {
            return redirect('admin/municipalities')->with('success', 'მუნიციპალიტეტი წარმატებით დაემატა');
        } else {
            return Redirect::route('admin/municipalities')->withInput()->with('error', 'დაფიქსირდა შეცდომა მუნიციპალიტეტის დამატების დროს');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $municipality
     * @return Response
     */
    public function edit(int $municipality)
    {
        $municipality = Municipality::findOrFail($municipality);

        return view('admin.municipalities.edit', compact('municipality'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MunicipalityRequest $request
     * @param Municipality $municipality
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MunicipalityRequest $request, int $municipality)
    {
        $municipality = Municipality::findOrFail($municipality);

        if ($municipality->update($request->all())) {
            return redirect('admin/municipalities')->with('success', 'მუნიციპალიტეტი წარმატებით განახლდა');
        } else {
            return Redirect::route('admin/municipalities')->withInput()->with('error', 'დაფიქსირდა შეცდომა მუნიციპალიტეტის განახლების დროს');
        }
    }

    /**
     * Remove blog.
     *
     * @param int $municipality
     * @return Response
     */
    public function getModalDelete(int $municipality)
    {
        $model = 'municipality';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.municipalities.delete', ['id' => $municipality]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {
            $error = 'დაფიქსირდა შეცდომა პროექტის კატეგორიის წაშლის დროს';
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $municipality
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $municipality)
    {
        $municipality = Municipality::findOrFail($municipality);

        if ($municipality->delete()) {
            return redirect('admin/municipalities')->with('success', 'მუნიციპალიტეტი წარმატებით წაიშალა');
        } else {
            return Redirect::route('admin/municipalities')->withInput()->with('error', 'დაფიქსირდა შეცდომა მუნიციპალიტეტის წაშლის დროს');
        }
    }
}
