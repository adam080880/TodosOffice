<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function permissions()
    {
        return $this->hasMany('App\Permission');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
