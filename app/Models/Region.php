<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name'];

    public function municipalities() {
        return $this->hasMany(Municipality::class, 'region_id');
    }
}
