<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    public $timestamps = [];
    protected $fillable = ['name', 'rate_id', 'parent_criteria_id', 'yes_point', 'no_point', 'is_percentable'];

    public function rate() {
        return $this->belongsTo(Rate::class, 'rate_id');
    }

    public function parentCriteria() {
        return $this->belongsTo(Criteria::class, 'parent_criteria_id');
    }

    public function subCriterias() {
        return $this->hasMany(Criteria::class, 'parent_criteria_id');
    }

    public function getIsYesNoPointAttribute() {
        return $this->yes_point !== null && $this->no_point !== null;
    }

    public function getIsPercentableAttribute() {
        return (bool)$this->attributes['is_percentable'];
    }

    public function getIsFreePointAttribute() {
        return !$this->isYesNoPoint && !$this->isPercentable;
    }

    public function getPointType() {
        if($this->isYesNoPoint) return 'yes_no';
        if($this->isPercentable) return 'percentable';
        if($this->isFreePoint) return 'free_point';
    }
}
