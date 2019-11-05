<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['parent_id', 'project_id', 'criteria', 'evaluation', 'point', 'percent_in_total', 'total_points'];

    public function parentEvaluation() {
        return $this->belongsTo(Evaluation::class, 'parent_id');
    }

    public function subEvaluations() {
        return $this->hasMany(Evaluation::class, 'parent_id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getIsNumberFormatAttribute() {
        return $this->evaluation == null;
    }

    public function getIsSubcriteriaAttribute() {
        return $this->parent_id !== null;
    }

    public function getTotalPoints() {
        return $this->subEvaluations()->sum('point');
    }
}
