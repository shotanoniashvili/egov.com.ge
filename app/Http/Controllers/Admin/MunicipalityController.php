<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\MunicipalityRequest;
use App\Models\Municipality;
use App\Models\ProjectCategory;
use App\Models\Region;
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
        $regions = Region::all();

        return view('admin.municipalities.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MunicipalityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MunicipalityRequest $request)
    {
        $data = $request->all();
        if($request->image) {
            $destinationPath = 'storage/municipalities/';
            $file = $request->image;
            $fileName = $file->getClientOriginalName();
            if(file_exists(public_path($destinationPath).$fileName)) {
                $fileName = time().'-'.$file->getClientOriginalName();
            }
            $file->move(public_path($destinationPath), $fileName);

            $data['image'] = $destinationPath.$fileName;
        }

        $municipality = new Municipality($data);

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

        $regions = Region::all();

        return view('admin.municipalities.edit', compact('municipality', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MunicipalityRequest $request
     * @param int $municipality
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MunicipalityRequest $request, int $municipality)
    {
        $municipality = Municipality::findOrFail($municipality);

        $data = $request->all();
        if($request->image) {
            $destinationPath = 'storage/municipalities/';
            $file = $request->image;
            $fileName = $file->getClientOriginalName();
            if(file_exists(public_path($destinationPath).$fileName)) {
                $fileName = time().'-'.$file->getClientOriginalName();
            }
            $file->move(public_path($destinationPath), $fileName);

            $data['image'] = $destinationPath.$fileName;
        } else {
            unset($data['image']);
        }

        if ($municipality->update($data)) {
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
