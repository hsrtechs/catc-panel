<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    public function make($name)
    {
        $this->name = $name;
        return $this->saveOrFail();
    }

    public function Users()
    {
        return $this->hasMany('App\User');
    }
}
