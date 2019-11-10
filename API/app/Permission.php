<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function feature()
    {
        return $this->belongsTo('App\Feature');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
}
