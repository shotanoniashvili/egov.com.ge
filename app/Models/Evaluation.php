<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evaluation extends Model
{
    protected $fillable = ['parent_evaluation_id', 'project_id', 'criteria_name', 'evaluation', 'point', 'expert_id'];

    public function expert() {
        return $this->belongsTo(User::class, 'expert_id');
    }

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

    public function scopeSuccess($query) {
        return $query->where('evaluations.criteria_name', 'წარმატებული')
            ->select(['evaluations.expert_id', 'subevaluations.point', 'subevaluations.parent_evaluation_id'])
            ->leftJoin('evaluations as subevaluations', 'evaluations.id', 'subevaluations.parent_evaluation_id');
    }

    public function scopeTransparent($query) {
        return $query->where('evaluations.criteria_name', 'გამჭვირვალე')
            ->select(['evaluations.expert_id', 'subevaluations.point', 'subevaluations.parent_evaluation_id'])
            ->leftJoin('evaluations as subevaluations', 'evaluations.id', 'subevaluations.parent_evaluation_id');
    }

    public function scopeAdequate($query) {
        return $query->where('evaluations.criteria_name', 'ადეკვატური')
            ->select(['evaluations.expert_id', 'subevaluations.point', 'subevaluations.parent_evaluation_id'])
            ->leftJoin('evaluations as subevaluations', 'evaluations.id', 'subevaluations.parent_evaluation_id');
    }

    public function scopeShareable($query) {
        return $query->where('evaluations.criteria_name', 'გაზიარებადი')
            ->select(['evaluations.expert_id', 'subevaluations.point', 'subevaluations.parent_evaluation_id'])
            ->leftJoin('evaluations as subevaluations', 'evaluations.id', 'subevaluations.parent_evaluation_id');
    }

    public function scopeSustainable($query) {
        return $query->where('evaluations.criteria_name', 'მდგრადი')
            ->select(['evaluations.expert_id', 'subevaluations.point', 'subevaluations.parent_evaluation_id'])
            ->leftJoin('evaluations as subevaluations', 'evaluations.id', 'subevaluations.parent_evaluation_id');
    }

    public function scopeExpert($query, $expertId) {
        return $query->where('evaluations.expert_id', $expertId);
    }
}
