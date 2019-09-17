<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'short_description',
        'municipality_id',
        'picture',
        'user_id',
        'is_archive',
        'is_active_for_experts',
        'is_active_for_web'
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

    public function scopeActiveForWeb($query) {
        return $query->where('is_active_for_web', true);
    }

    public function scopeActiveForExpert($query) {
        return $query->where('is_active_for_experts', true);
    }

    public function scopeEvaluated($query) {
        return $query;
    }

    public function scopeToEvaluate($query) {
        return $query;
    }

    public function getShortDescriptionAttribute() {
        return stripslashes($this->attributes['short_description']);
    }

    /**
     * @param $title
     * @param $categoryId
     * @param $shortDescription
     * @param $municipalityId
     * @param $picture
     * @param $userId
     * @param $documents
     * @param bool $isArchive
     * @param bool $isActiveForExperts
     * @param bool $isActiveForWeb
     * @param null $projectDate
     * @throws \Exception
     */
    public static function createProject($title,
                                         $categoryId,
                                         $shortDescription,
                                         $municipalityId,
                                         $picture,
                                         $userId,
                                         $documents,
                                         $isArchive = false,
                                         $isActiveForExperts = true,
                                         $isActiveForWeb = false,
                                         $projectDate = null) {
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
                $project->created_at = \DateTime::createFromFormat('Y-m-d', $projectDate);
            }

            if($picture) {
                $destinationPath = 'storage/projects/pictures/';
                $fileName = $picture->getClientOriginalName();
                if(file_exists(public_path($destinationPath).$fileName)) {
                    $fileName = time().'-'.$fileName;
                }
                $picture->move(public_path($destinationPath), $fileName);

                $path = $destinationPath.$fileName;

                $project->picture = $path;
            }

            $project->save();

            $project->uploadDocuments($documents);
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
        if($this->is_active_for_experts && !$this->is_active_for_web) return 'შეფასების პროცესშია';

        if($this->is_active_for_experts && !$this->is_active_for_web) return 'უარყოფილია';

        return 'მიღებულია';
    }

    public function getShortDescription() {
        $stripped = strip_tags($this->short_description);

        return (strlen($stripped) > 160) ? substr($stripped, 0, 160).'...' : $stripped;
    }

    public function getRating() {
        // TODO
        return '-';
    }

    public function delete() {
        try {
            $this->documents()->delet();

            parent::delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
