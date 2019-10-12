<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model implements \App\Interfaces\Searchable
{
    use Searchable;

    protected $fillable = ['name', 'region_id', 'website', 'image'];

    public function projects() {
        return $this->hasMany(Project::class, 'municipality_id');
    }

    public function region() {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_municipalities', 'municipality_id', 'user_id');
    }

    public function getSimilar($project) {
        return $this->projects()->activeForWeb()->where('id', '!=', $project->id)->inRandomOrder()->take(5)->get();
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getTitle()
    {
        return $this->name;
    }

    public function getLink()
    {
        return route('municipalities.show', $this->id);
    }

    public function getDate()
    {
        return '';
    }

    public function getModelName()
    {
        return 'მუნიციპალიტეტი';
    }

    public function getSearchableColumns()
    {
        return ['name'];
    }

    public function getDescription()
    {
        return $this->projects()->count().' პრაქტიკა / ინიციატივა';
    }
}
