<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\RateRequest;
use App\Http\Resources\RateResource;
use App\Models\Municipality;
use App\Models\Person;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Sentinel;

class RatesController extends JoshController
{
    public function index() {
        $rates = Rate::all();

        return view('admin.rates.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projectCategories = ProjectCategory::all();

        return view('admin.rates.create', compact('projectCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rateData = json_decode($request->data);

        try {
            Rate::addRate($rateData->name, $rateData->project_category_id, $rateData->criterias);

            return redirect('admin/rates')->with('success', 'შეფასება წარმატებით დაემატა');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'დაფიქსირდა შეცდომა შეფასების დამატების დროს.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $rate = Rate::findOrFail($id);

        return view('admin.rates.edit', compact('rate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $rate = Rate::findOrFail($id);

        $rateData = json_decode($request->data);

        try {
            $rate->updateRate($rateData->name, $rateData->project_category_id, $rateData->criterias);

            return redirect('admin/rates')->with('success', 'შეფასება წარმატებით დარედაქტირდა');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'დაფიქსირდა შეცდომა შეფასების რედაქტირების დროს.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $rate = Rate::findOrFail($id);

        DB::beginTransaction();
        try {
            $rate->criterias()->delete();

            $rate->delete();

            DB::commit();
            return redirect('admin/rates')->with('success', 'შეფასება წარმატებით წაიშალა');
        } catch (\Exception $e) {
            return redirect('admin/rates')->with('error', 'დაფიქსირდა შეცდომა შეფასების წაშლის დროს.');
        }
    }

    public function getRate(int $id) {
        $rate = Rate::findOrFail($id);

        return new RateResource($rate);
    }
}
