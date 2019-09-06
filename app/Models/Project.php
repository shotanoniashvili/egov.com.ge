<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'author_person_id',
        'short_description',
        'municipality_id',
        'detailed_description',
        'goal',
        'experience',
        'council_contribution',
        'future_plans',
        'contact_person_id',
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

    public function authorPerson() {
        return $this->belongsTo(Person::class, 'author_person_id');
    }

    public function contactPerson() {
        return $this->belongsTo(Person::class, 'contact_person_id');
    }

    public function uploaderUser() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documents() {
        return $this->hasMany(ProjectDocument::class, 'project_id');
    }

    /**
     * @param $title
     * @param $categoryId
     * @param $shortDescription
     * @param $municipalityId
     * @param $detailedDescription
     * @param $goal
     * @param $experience
     * @param $councilContribution
     * @param $futurePlans
     * @param $authorId
     * @param $contactPersonId
     * @param $userId
     * @param $documents
     * @throws \Exception
     */
    public static function createProject($title,
                                         $categoryId,
                                         $shortDescription,
                                         $municipalityId,
                                         $detailedDescription,
                                         $goal,
                                         $experience,
                                         $councilContribution,
                                         $futurePlans,
                                         $authorId,
                                         $contactPersonId,
                                         $userId,
                                         $documents) {
        try {
            $project = new Project();

            $project->title = $title;
            $project->category_id = $categoryId;
            $project->short_description = $shortDescription;
            $project->municipality_id = $municipalityId;
            $project->detailed_description = $detailedDescription;
            $project->goal = $goal;
            $project->experience = $experience;
            $project->council_contribution = $councilContribution;
            $project->future_plans = $futurePlans;
            $project->author_person_id = $authorId;
            $project->contact_person_id = $contactPersonId;
            $project->is_archive = false;
            $project->user_id = $userId;
            $project->is_active_for_experts = true;
            $project->is_active_for_web = false;

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
        $destinationPath = 'storage/projects/';

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
}
