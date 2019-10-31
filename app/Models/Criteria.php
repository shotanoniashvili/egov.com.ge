<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public $timestamps = [];
    protected $fillable = ['name', 'rate_id', 'parent_criteria_id', 'percent_in_total', 'max_point', 'yes_point', 'no_point'];

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
}
