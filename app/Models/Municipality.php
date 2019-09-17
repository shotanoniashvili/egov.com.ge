<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = ['name', 'region_id', 'website', 'image'];

    public function projects() {
        return $this->hasMany(Project::class, 'municipality_id');
    }

    public function region() {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function getSimilar($project) {
        return $this->projects()->activeForWeb()->where('id', '!=', $project->id)->inRandomOrder()->take(5)->get();
    }
}
