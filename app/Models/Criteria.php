<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public $timestamps = [];
    protected $fillable = ['name', 'rate_id', 'parent_criteria_id', 'percent_in_total', 'max_point', 'yes_point', 'no_point'];

    protected $appends = ['total_max_points'];

    public function rate() {
        return $this->belongsTo(Rate::class, 'rate_id');
    }

    public function parentCriteria() {
        return $this->belongsTo(Criteria::class, 'parent_criteria_id');
    }

    public function subCriterias() {
        return $this->hasMany(Criteria::class, 'parent_criteria_id');
    }

    public function getIsNumberFormatAttribute() {
        return $this->max_point != null && $this->yes_point == null;
    }

    public function getMaxTotalPoints() {
        if(!$this->total_max_points) {
            $this->total_max_points = 0;
            foreach ($this->subCriterias as $criteria) {
                if($criteria->max_point != null) {
                    $this->total_max_points += $criteria->max_point;
                } else {
                    if($criteria->yes_point > $criteria->no_point) $this->total_max_points += $criteria->yes_point;
                    if($criteria->yes_point < $criteria->no_point) $this->total_max_points += $criteria->no_point;
                }
            }
        }

        return $this->total_max_points;
    }
}
