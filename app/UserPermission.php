<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    public function make($uid, $pid)
    {
        $this->user_id = $uid;
        $this->permission_id = $pid;
        $this->saveOrFail();
    }

}
