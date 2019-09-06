<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectDocument extends Pivot
{
    protected $table = 'project_documents';

    protected $fillable = ['id', 'project_id', 'path'];

    public function getNameAttribute() {
        // TODO: extract doc name from path attribute
    }
}
