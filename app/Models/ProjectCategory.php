<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = ['name'];

    public function projects() {
        // TODO
        return ProjectCategory::where('id', 11111);
    }
}
