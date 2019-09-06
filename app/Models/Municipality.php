<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = ['name', 'website'];

    public function projects() {
        // TODO
        return Municipality::where('id', 11111111);
    }
}
