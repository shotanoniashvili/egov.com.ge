<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Person;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $authorPersonData = $request->author;
            $authorPersonData['mobiles'] = json_encode($authorPersonData['mobiles']);
            $authorPerson = Person::create($authorPersonData);

            $contactPersonData = $request->contact_person;
            $contactPersonData['mobiles'] = json_encode($contactPersonData['mobiles']);
            $contactPerson = Person::create($contactPersonData);

            Project::createProject(
                $request->title,
                $request->category_id,
                $request->short_description,
                $request->municipality_id,
                $request->detailed_description,
                $request->goal,
                $request->experience,
                $request->council_contribution,
                $request->future_plans,
                $authorPerson->id,
                $contactPerson->id,
                auth()->user()->id,
                $request->documents);
            DB::commit();
            return redirect()->route('my-account.uploaded')->withSuccess('პროექტი წარმატებით აიტვირთა');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withError('დაფიქსირდა შეცდომა პრაქტიკის/ინიციატივის დამატების დროს');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
