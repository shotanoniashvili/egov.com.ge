<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['name', 'project_category_id'];

    public function projectCategory() {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function criterias() {
        return $this->hasMany(Criteria::class, 'rate_id');
    }
}
