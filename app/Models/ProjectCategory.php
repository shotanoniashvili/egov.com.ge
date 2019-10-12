<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = ['name'];

    public function projects() {
        return $this->hasMany(Project::class, 'category_id');
    }

    public function experts() {
        return $this->belongsToMany(User::class, 'user_project_categories', 'category_id', 'user_id');
    }
}
