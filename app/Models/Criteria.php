<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = ['name', 'parent_criteria_id', 'percent_in_total', 'max_point', 'yes_point', 'no_point'];

    public function parentCriteria() {
        return $this->belongsTo(Criteria::class, 'parent_criteria_id');
    }

    public function subCriterias() {
        return $this->hasMany(Criteria::class, 'parent_criteria_id');
    }
}