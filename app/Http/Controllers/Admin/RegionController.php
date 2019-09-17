<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\RegionRequest;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class RegionController extends JoshController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $regions = Region::all();
        // Show the page
        return view('admin.region.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.region.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegionRequest $request)
    {
        $region = new Region($request->all());

        if ($region->save()) {
            return redirect('admin/regions')->with('success', 'რეგიონი წარმატებით დაემატა');
        } else {
            return Redirect::route('admin/regions')->withInput()->with('error', 'დაფიქსირდა შეცდომა რეგიონის დამატების დროს');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Region $region
     * @return Response
     */
    public function edit(int $region)
    {
        $region = Region::findOrFail($region);

        return view('admin.region.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RegionRequest $request
     * @param Region $region
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RegionRequest $request, int $region)
    {
        $region = Region::findOrFail($region);

        if ($region->update($request->all())) {
            return redirect('admin/regions')->with('success', 'რეგიონი წარმატებით განახლდა');
        } else {
            return Redirect::route('admin/regions')->withInput()->with('error', 'დაფიქსირდა შეცდომა რეგიონის განახლების დროს');
        }
    }

    /**
     * Remove blog.
     *
     * @param int $region
     * @return Response
     */
    public function getModalDelete(int $region)
    {
        $model = 'region';
        $confirm_route = $error = null;
        try {
            $confirm_route = route('admin.regions.delete', ['id' => $region]);
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {
            $error = 'დაფიქსირდა შეცდომა რეგიონის წაშლის დროს';
            return view('admin.layouts.modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $region
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $region)
    {
        $region = Region::findOrFail($region);

        if ($region->delete()) {
            return redirect('admin/regions')->with('success', 'რეგიონი წარმატებით წაიშალა');
        } else {
            return Redirect::route('admin/regions')->withInput()->with('error', 'დაფიქსირდა შეცდომა რეგიონის წაშლის დროს');
        }
    }
}
