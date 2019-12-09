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

    public function customCriterias() {
        return $this->hasMany(CustomCriteria::class, 'criteria_id');
    }

    public function getIsCustomPointAttribute() {
        return $this->customCriterias()->count() > 0;
    }

    public function getIsPercentableAttribute() {
        return (bool)$this->attributes['is_percentable'];
    }

    public function getIsFreePointAttribute() {
        return !$this->isCustomPoint && !$this->isPercentable;
    }

    public function getPointType() {
        if($this->isCustomPoint) return 'custom_criteria';
        if($this->isPercentable) return 'percentable';
        if($this->isFreePoint) return 'free_point';
    }

    public function delete()
    {
        $this->customCriterias()->delete();

        return parent::delete();
    }
}
