<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rate extends Model
{
    public $timestamps = [];
    protected $fillable = ['name', 'project_category_id'];

    public function projectCategory() {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function criterias() {
        return $this->hasMany(Criteria::class, 'rate_id')->whereNull('parent_criteria_id');
    }

    public function subCriterias() {
        return $this->hasMany(Criteria::class, 'rate_id')->whereNotNull('parent_criteria_id');
    }

    /**
     * @param $name
     * @param $projectCategoryId
     * @param $criterias
     * @throws \Exception
     */
    public static function addRate($name, $projectCategoryId, $criterias) {
        DB::beginTransaction();
        try {
            $rate = Rate::create([
                'name' => $name,
                'project_category_id' => $projectCategoryId
            ]);

            foreach ($criterias as $criteriaData) {
                //'name', 'rate_id', 'parent_criteria_id', 'percent_in_total', 'max_point', 'yes_point', 'no_point'
                $criteria = Criteria::create([
                    'name' => $criteriaData->name,
                    'rate_id' => $rate->id,
                    'percent_in_total' => $criteriaData->percent_in_total,
                ]);

                foreach ($criteriaData->subcriterias as $subcriteriaData) {
                    $subcriteria = new Criteria([
                        'name' => $subcriteriaData->name,
                        'rate_id' => $rate->id,
                        'parent_criteria_id' => $criteria->id,
                    ]);

                    if($subcriteriaData->number_field == 1) {
                        $subcriteria->max_point = $subcriteriaData->max_point;
                    } else {
                        $subcriteria->yes_point = $subcriteriaData->yes_point;
                        $subcriteria->no_point = $subcriteriaData->no_point;
                    }

                    $subcriteria->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $name
     * @param $projectCategoryId
     * @param $criterias
     * @throws \Exception
     */
    public function updateRate($name, $projectCategoryId, $criterias) {
        DB::beginTransaction();
        try {
            $this->name = $name;
            $this->project_category_id = $projectCategoryId;
            $this->save();

            $this->subCriterias()->delete();
            $this->criterias()->delete();

            foreach ($criterias as $criteriaData) {
                $criteria = Criteria::create([
                    'name' => $criteriaData->name,
                    'rate_id' => $this->id,
                    'percent_in_total' => $criteriaData->percent_in_total,
                ]);

                foreach ($criteriaData->subcriterias as $subcriteriaData) {
                    $subcriteria = new Criteria([
                        'name' => $subcriteriaData->name,
                        'rate_id' => $this->id,
                        'parent_criteria_id' => $criteria->id,
                    ]);

                    if($subcriteriaData->number_field == 1) {
                        $subcriteria->max_point = $subcriteriaData->max_point;
                    } else {
                        $subcriteria->yes_point = $subcriteriaData->yes_point;
                        $subcriteria->no_point = $subcriteriaData->no_point;
                    }

                    $subcriteria->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
