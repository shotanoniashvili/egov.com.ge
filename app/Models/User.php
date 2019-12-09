<?php namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

class User extends EloquentUser
{
    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'users';

    /**
     * The attributes to be fillable from the model.
     *
     * A dirty hack to allow fields to be fillable by calling empty fillable array
     *
     * @var array
     */
    use Taggable;

    protected $fillable = [];
    protected $guarded = ['id'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
    * To allow soft deletes
    */
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['full_name'];
    public function getFullNameAttribute()
    {
        return str_limit($this->first_name . ' ' . $this->last_name, 30);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function projects() {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function municipalities() {
        return $this->belongsToMany(Municipality::class, 'user_municipalities', 'user_id', 'municipality_id');
    }

    public function categories() {
        return $this->belongsToMany(ProjectCategory::class, 'user_project_categories', 'user_id', 'category_id');
    }

    public function projectsAsExpert() {
        return Project::whereIn('category_id', $this->categories->pluck('id')->toArray());
    }

    public function getEvaluatedProjects() {
        $projects = $this->projectsAsExpert()->evaluated($this->id)->orderByDesc('created_at')->get();

        return $projects;
    }

    public function getProjectsToEvaluate() {
        $projects = $this->projectsAsExpert()->toEvaluate($this->id)->orderByDesc('created_at')->get();

        return $projects;
    }
}
