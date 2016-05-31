<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'task_id',
    ];

    public function server()
    {
        return $this->belongsTo('App\Server');
    }
}
