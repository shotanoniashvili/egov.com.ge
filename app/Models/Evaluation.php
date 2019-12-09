<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evaluation extends Model
{
    protected $fillable = ['parent_evaluation_id', 'project_id', 'criteria_name', 'evaluation', 'point'];

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
        return $this->parent_evaluation_id !== null;
    }

    public function getTotalPoints() {
        return $this->subEvaluations()->sum('point');
    }

    public function delete()
    {
        foreach ($this->subEvaluations()->get() as $evaluation) {
            $evaluation->delete();
        }

        return parent::delete();
    }
}
