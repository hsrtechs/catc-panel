<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ActivationCode extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'code',
        'username',
        'created_at'
    ];
    protected $dates = [
        'created_at'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }


    public function make($username)
    {
        $code = str_random(64);
        $this->create([
            'code' => $code,
            'username' => $username,
            'created_at' => Carbon::now(),
        ]);
        return $code;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
