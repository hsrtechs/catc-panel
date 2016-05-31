<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function make($name)
    {
        $this->name = $name;
        return $this->saveOrFail();
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_permissions');
    }
}
