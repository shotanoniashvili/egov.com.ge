<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Criteria;
use App\Models\CustomCriteria;
use App\Models\Evaluation;
use App\Models\Municipality;
use App\Models\Person;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Sentinel;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bestPractice(Request $request)
    {
        $projects = Project::activeForWeb()->notArchive()->bestPractise();

        $this->applyFilters($projects, $request);

        $projects = $projects->paginate(15);

        $municipalities = Municipality::all();
        $categories = ProjectCategory::all();

        return view('projects/best-practice', compact('projects', 'municipalities', 'categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function archive(Request $request)
    {
        $projects = Project::archive();

        $projects = $this->applyFilters($projects, $request);

        $projects->orderByDesc('created_at');

        $projects = $projects->paginate(15);

        $municipalities = Municipality::all();
        $categories = ProjectCategory::all();

        return view('projects/archive', compact('projects', 'municipalities', 'categories'));
    }

    private function applyFilters($projectsQuery, $request) {
        if($request->years && is_array($request->years)) {
            $projectsQuery->where(function($q) use ($request) {
                foreach ($request->years as $year) {
                    $q->whereYear('created_at', '=', $year, 'or');
                }
            });
        }

        if($request->categories && is_array($request->categories)) {
            $projectsQuery->whereIn('category_id', $request->categories);
        }

        if($request->municipalities && is_array($request->municipalities)) {
            $projectsQuery->whereIn('municipality_id', $request->municipalities);
        }

        return $projectsQuery;
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
            Project::createProject(
                $request->title,
                $request->category_id,
                $request->short_description,
                $request->municipality_id,
                $request->picture,
                Sentinel::getUser()->id,
                $request->documents);
            DB::commit();
            return redirect()->route('my-account.uploaded')->withSuccess('პრაქტიკა/ინიციატივა წარმატებით დაემატა');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("ProjectController->store::$request -> ".json_encode($request->all()) . ". \n\rMessage: ".$e->getMessage());
            return redirect()->back()->withInput()->withError('დაფიქსირდა შეცდომა პრაქტიკის/ინიციატივის დამატების დროს');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(int $project)
    {
        $project = Project::findOrFail($project);

        $user = Sentinel::getUser();

        $isAdmin = $user && $user->roles()->where('slug', 'admin')->count() > 0;
        $isAuthor = $user && $user->id === $project->user_id;
        $isExpert = $user && $project->is_active_for_experts && $user->categories()->where('id', $project->category->id)->count() > 0;

        if( $isAdmin
            || $project->is_active_for_web
            || $isAuthor
            || $isExpert) {
            if($isAdmin || $isExpert || $isAuthor || $project->is_archive) {
                $projectDocuments = $project->documents()->get();
            } else {
                $projectDocuments = $project->documents()->visible()->get();
            }

            return view('projects.show', compact('project', 'projectDocuments'));
        }

        return redirect()->to(url()->to('/best-practice'));
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

    public function showEvaluatedProjects() {
        $user = Sentinel::getUser();

        $projects = $user->getEvaluatedProjects();

        return view('user_account.uploaded_projects', compact('projects'));
    }

    public function showProjectsToEvaluate() {
        $user = Sentinel::getUser();

        $projects = $user->getProjectsToEvaluate();

        return view('user_account.uploaded_projects', compact('projects'));
    }

    public function showEvaluateForm(int $id) {
        $user = Sentinel::getUser();

        if($user->getProjectsToEvaluate()->where('id', $id)->count() == 0) return abort(404);

        $project = Project::findOrFail($id);
        if($project->getStatus() == 'შეფასებული') return abort(404);
        if($project->evaluations()->where('expert_id', $user->id)->count() > 0) return abort(404);

        return view('projects.evaluate', compact('project'));
    }

    public function evaluate(Request $request, int $id) {
        $user = Sentinel::getUser();

        //if($user->getProjectsToEvaluate()->where('id', $id)->count() == 0) return abort(404);

        $project = Project::findOrFail($id);
        //if($project->getStatus() == 'შეფასებული') return abort(404);
        //if($project->evaluations()->where('expert_id', $user->id)->count() > 0) return abort(404);

        DB::beginTransaction();
        try {
            $totalPoints = 0;
            foreach ($request->criterias as $criteriaId => $value) {
                $criteria = Criteria::findOrFail($criteriaId);

                $parentEvaluation = Evaluation::create([
                    'project_id' => $id,
                    'criteria_name' => $criteria->name,
                    'expert_id' => Sentinel::getUser()->id,
                ]);

                foreach ($value as $subCriteriaId => $evaluatedValue) {
                    $subCriteria = Criteria::findOrFail($subCriteriaId);

                    $evaluation = null;
                    if(is_array($evaluatedValue) && array_key_exists('free_point', $evaluatedValue)) {
                        $point = $evaluatedValue['free_point'];
                    }

                    if(is_array($evaluatedValue) && array_key_exists('custom_point', $evaluatedValue)) {
                        $custom = CustomCriteria::findOrFail($evaluatedValue['custom_point']);
                        $point = $custom->point;
                        $evaluation = $custom->title;
                    }

                    if(is_array($evaluatedValue) && array_key_exists('percent', $evaluatedValue)) {
                        $point = (int)($evaluatedValue['percent']/10);
                        $evaluation = $evaluatedValue['percent'] . ' პროცენტი';
                    }

                    $subEvaluation = Evaluation::create([
                        'parent_evaluation_id' => $parentEvaluation->id,
                        'project_id' => $id,
                        'criteria_name' => $subCriteria->name,
                        'evaluation' => $evaluation,
                        'point' => $point,
                        'expert_id' => Sentinel::getUser()->id,
                    ]);

                    $totalPoints += $point;
                }
            }

            $project->rating_points += $totalPoints;
            $project->save();

            DB::commit();
            return redirect()->route('projects.rating', $id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withError('დაფიქსირდა შეცდომა პრაქტიკის/ინიციატივის შეფასების დროს'. $e->getMessage());
        }
    }

    public function rating(int $id, int $expertId) {
        $expert = User::findOrFail($expertId);

        $project = Project::with(['evaluations' => function($q) use ($expertId) {
            $q->where('expert_id', $expertId);
        }])->where('id', $id)->firstOrFail();

        return view('projects.evaluated', compact('project', 'expert'));
    }
}
