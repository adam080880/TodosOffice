<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function duties()
    {
        return $this->hasMany('App\TaskFor');
    }
}
