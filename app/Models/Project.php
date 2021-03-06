<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model implements \App\Interfaces\Searchable
{
    use Searchable;

    protected $fillable = [
        'title',
        'category_id',
        'short_description',
        'municipality_id',
        'image',
        'user_id',
        'is_best_practise',
        'is_archive',
        'is_active_for_experts',
        'is_active_for_web',
        'rating_points',
        ];


    public function category() {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function municipality() {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function uploaderUser() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documents() {
        return $this->hasMany(ProjectDocument::class, 'project_id');
    }

    public function evaluations() {
        return $this->hasMany(Evaluation::class, 'project_id')->whereNull('evaluations.parent_evaluation_id');
    }

    public function scopeActiveForWeb($query) {
        return $query->where('is_active_for_web', true);
    }

    public function scopeActiveForExpert($query) {
        return $query->where('is_active_for_experts', true);
    }

    public function scopeEvaluated($query, $expertId = null) {
        if($expertId != null) {
            $query->whereHas('evaluations', function($q) use ($expertId) {
                $q->where('expert_id', $expertId);
            });
        }
        return $query->whereNotNull('rating_points');
    }

    public function scopeToEvaluate($query, $expertId = null) {
        $query->where(function($q) {
            $q->whereNull('rating_points');
            $q->orWhere('rating_points', 0);
        });

        if($expertId) {
            $query->orWhere(function($q) use($expertId) {
                $q->whereDoesntHave('evaluations', function($q2) use($expertId) {
                    $q2->where('expert_id', $expertId);
                });
            });
        }

        return $query;
    }

    public function scopeArchive($query) {
        return $query->where('is_archive', true);
    }

    public function scopeNotArchive($query) {
        return $query->where('is_archive', false);
    }

    public function scopeBestPractise($query) {
        return $query->where('is_best_practise', true);
    }

    public function getShortDescriptionAttribute() {
        return stripslashes($this->attributes['short_description']);
    }

    public function getPictureAttribute() {
        return $this->image;
    }

    /**
     * @param $title
     * @param $categoryId
     * @param $shortDescription
     * @param $municipalityId
     * @param $image
     * @param $userId
     * @param $documents
     * @param bool $isBestPractise
     * @param bool $isArchive
     * @param bool $isActiveForExperts
     * @param bool $isActiveForWeb
     * @param null $projectDate
     * @param null $ratingPoint
     * @throws \Exception
     */
    public static function createProject($title,
                                         $categoryId,
                                         $shortDescription,
                                         $municipalityId,
                                         $image,
                                         $userId,
                                         $documents,
                                         $isBestPractise = false,
                                         $isArchive = false,
                                         $isActiveForExperts = true,
                                         $isActiveForWeb = false,
                                         $projectDate = null,
                                         $ratingPoint = null) {
        try {
            $project = new Project();

            $project->title = $title;
            $project->category_id = $categoryId;
            $project->short_description = addslashes($shortDescription);
            $project->municipality_id = $municipalityId;
            $project->is_archive = $isArchive;
            $project->user_id = $userId;
            $project->is_best_practise = $isBestPractise;
            $project->is_active_for_experts = $isActiveForExperts;
            $project->is_active_for_web = $isActiveForWeb;
            if($projectDate !== null && $projectDate !== '') {
                $project->created_at = \DateTime::createFromFormat('Y', $projectDate);
                $project->rating_points = $ratingPoint;
            }

            if($image) {
                $destinationPath = 'storage/projects/pictures/';
                $fileName = $image->getClientOriginalName();
                if(file_exists(public_path($destinationPath).$fileName)) {
                    $fileName = time().'-'.$fileName;
                }
                $image->move(public_path($destinationPath), $fileName);

                $path = $destinationPath.$fileName;

                $project->image = $path;
            }

            $project->save();

            $project->uploadDocuments($documents);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $title
     * @param $categoryId
     * @param $shortDescription
     * @param $municipalityId
     * @param $image
     * @param $userId
     * @param $documents
     * @param bool $isBestPractise
     * @param bool $isArchive
     * @param bool $isActiveForExperts
     * @param bool $isActiveForWeb
     * @param null $projectDate
     * @param null $ratingPoint
     * @throws \Exception
     */
    public function updateProject($title,
                                         $categoryId,
                                         $shortDescription,
                                         $municipalityId,
                                         $image,
                                         $userId,
                                         $documents,
                                         $isBestPractise = false,
                                         $isArchive = false,
                                         $isActiveForExperts = true,
                                         $isActiveForWeb = false,
                                         $projectDate = null,
                                         $ratingPoint = null) {
        try {
            $this->title = $title;
            $this->category_id = $categoryId;
            $this->short_description = addslashes($shortDescription);
            $this->municipality_id = $municipalityId;
            $this->is_archive = $isArchive;
            $this->user_id = $userId;
            $this->is_best_practise = $isBestPractise;
            $this->is_active_for_experts = $isActiveForExperts;
            $this->is_active_for_web = $isActiveForWeb;
            if($projectDate !== null && $projectDate !== '') {
                $this->created_at = \DateTime::createFromFormat('Y', $projectDate);
                $this->rating_points = $ratingPoint;
            }

            if($image) {
                $destinationPath = 'storage/projects/pictures/';
                $fileName = $image->getClientOriginalName();
                if(file_exists(public_path($destinationPath).$fileName)) {
                    $fileName = time().'-'.$fileName;
                }
                $image->move(public_path($destinationPath), $fileName);

                $path = $destinationPath.$fileName;

                $this->image = $path;
            }

            $this->save();

            if($documents && is_array($documents)) {
                $this->uploadDocuments($documents);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $documents
     * @throws \Exception
     */
    public function uploadDocuments($documents) {
        $destinationPath = 'storage/projects/docs/';

        DB::beginTransaction();
        try {
            foreach ($documents as $document) {
                $fileName = $document->getClientOriginalName();
                if(file_exists(public_path($destinationPath).$fileName)) {
                    $fileName = time().'-'.$document->getClientOriginalName();
                }
                $document->move(public_path($destinationPath), $fileName);

                $path = $destinationPath.$fileName;

                $this->documents()->save(new ProjectDocument([
                    'path' => $path
                ]));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }

    public function getStatus() {
        // TODO ??????????????? ??????????????? ???????????????????????? ????????????????????? ??????????????????????????????
        if($this->category->experts()->count() == $this->getEvaluatedExperts()->count()) return '?????????????????????????????????';

        //if($this->rating_points !== null && $this->rating_points != 0) return '?????????????????????????????????';

        if(($this->is_active_for_experts && !$this->is_active_for_web) || $this->rating_points == null || $this->rating_points == 0) return '??????????????????????????? ???????????????????????????';

        if(!$this->is_active_for_experts && !$this->is_active_for_web) return '??????????????????????????????';

        return '???????????????????????????';
    }

    public function getShortDescription() {
        $stripped = strip_tags($this->short_description);

        return (strlen($stripped) > 160) ? mb_substr($stripped, 0, 160).'...' : $stripped;
    }

    public function getRating() {
        return ($this->getEvaluatedExperts()->count() > 0) ? number_format($this->rating_points / $this->getEvaluatedExperts()->count(), 2) : 0;
    }

    public function delete() {
        try {
            $this->documents()->delete();

            foreach ($this->evaluations()->get() as $evaluation) {
                $evaluation->delete();
            }

            return parent::delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLink()
    {
        return route('projects.show', $this->id);
    }

    public function getDate()
    {
        return $this->created_at->format('Y-m-d H:i');
    }

    public function getModelName()
    {
        return '???????????????????????? / ??????????????????????????????';
    }

    public function getSearchableColumns()
    {
        return ['title', 'short_description'];
    }

    public function getDescription()
    {
        return $this->getShortDescription();
    }

    public function getEvaluatedExperts() {
        $expertIds = $this->evaluations()->select('expert_id')->distinct()->get();

        return User::whereIn('id', $expertIds)->get();
    }

    public function getRatingSumByExpert($expertId) {
        $evaluations = DB::table('evaluations')->where('expert_id', $expertId)->where('project_id', $this->id)->whereNotNull('point');

        return $evaluations->sum('point');
    }

    public function isEvaluatedByExpert($expertId) {
        return $this->evaluations()->where('expert_id', $expertId)->count() > 0;
    }

    public function reloadRatingPoints() {
        $this->rating_points = DB::table('evaluations')->where('project_id', $this->id)->whereNotNull('point')->sum('point');
        $this->save();
    }
}
