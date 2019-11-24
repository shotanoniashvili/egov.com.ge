<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['parent_evaluation_id', 'project_id', 'criteria', 'evaluation', 'point', 'point_type'];

    public function parentEvaluation() {
        return $this->belongsTo(Evaluation::class, 'parent_evaluation_id');
    }

    public function subEvaluations() {
        return $this->hasMany(Evaluation::class, 'parent_evaluation_id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getIsSubcriteriaAttribute() {
        return $this->parent_id !== null;
    }

    public function getTotalPoints() {
        return $this->subEvaluations()->sum('point');
    }
}
