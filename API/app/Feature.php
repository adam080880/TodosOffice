<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function permissions()
    {
        return $this->hasMany('App\Permission');
    }
}
