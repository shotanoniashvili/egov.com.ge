<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomCriteria extends Pivot
{
    protected $table = 'custom_criteria';
    public $timestamps = false;

    public $fillable = ['criteria_id', 'title', 'point', 'order'];

    public function criteria() {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }
}
