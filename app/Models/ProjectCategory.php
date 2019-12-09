<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = ['name', 'year'];

    public function projects() {
        return $this->hasMany(Project::class, 'category_id');
    }

    public function experts() {
        return $this->belongsToMany(User::class, 'user_project_categories', 'category_id', 'user_id');
    }

    public function rates() {
        return $this->hasOne(Rate::class, 'project_category_id');
    }

    public function scopeCurrentYear($query) {
        return $query->where('year', (new \DateTime())->format('Y-m-d'));
    }

    public function delete()
    {
        $this->experts()->detach();

        return parent::delete();
    }
}
