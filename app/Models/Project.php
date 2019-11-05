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
        'is_archive',
        'is_active_for_experts',
        'is_active_for_web',
        'rating_points'
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
        return $this->hasMany(Evaluation::class, 'project_id')->whereNull('parent_id');
    }

    public function scopeActiveForWeb($query) {
        return $query->where('is_active_for_web', true);
    }

    public function scopeActiveForExpert($query) {
        return $query->where('is_active_for_experts', true);
    }

    public function scopeEvaluated($query) {
        return $query->whereNotNull('rating_points');
    }

    public function scopeToEvaluate($query) {
        return $query->whereNull('rating_points');
    }

    public function scopeArchive($query) {
        return $query->where('is_archive', true);
    }

    public function scopeNotArchive($query) {
        return $query->where('is_archive', false);
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
        if($this->rating_points !== null) return 'შეფასებულია';

        if(($this->is_active_for_experts && !$this->is_active_for_web) || $this->rating_points == null) return 'შეფასების პროცესშია';

        if(!$this->is_active_for_experts && !$this->is_active_for_web) return 'უარყოფილია';

        return 'მიღებულია';
    }

    public function getShortDescription() {
        $stripped = strip_tags($this->short_description);

        return (strlen($stripped) > 160) ? substr($stripped, 0, 160).'...' : $stripped;
    }

    public function getRating() {
        return $this->rating_points;
    }

    public function delete() {
        try {
            $this->documents()->delete();

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
        return 'პრაქტიკა / ინიციატივა';
    }

    public function getSearchableColumns()
    {
        return ['title', 'short_description'];
    }

    public function getDescription()
    {
        return $this->getShortDescription();
    }
}
