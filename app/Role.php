<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function make($name)
    {
        $this->name = $name;
        $this->save();
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function getAdminsCount()
    {
        return $this->findOrFail(1)->users()->get()->count();
    }

    public function getModsCount()
    {
        return $this->findOrFail(2)->users()->get()->count();
    }

    public function getResellersCount()
    {
        return $this->findOrFail(3)->users()->get()->count();
    }

    public function getNormalUsersCount()
    {
        return $this->findOrFail(4)->users()->get()->count();
    }
    

}
