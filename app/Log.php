<?php

namespace App;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Log
 * @package App
 */
class Log extends Model
{
    /**
     * Table name for the model
     *
     * @var string
     */
    protected $table = 'logs';
    /**
     * Fields that do not trigger mass exception errors.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'desc', 'action_code', 'ip', 'type', 'sid', 'user_id'];

    public static function make($data = [])
    {
        $additions = [
            'user_id' => Auth::user()->id,
            'ip' => Request::ip(),
        ];

        static::create(array_merge($additions, $data));
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getIpAttribute($value)
    {
        return long2ip($value);
    }

    /**
     * @param $value
     */
    public function setIpAttribute($value)
    {
        $this->attributes['ip'] = ip2long($value);
    }

    /**
     * @param $value
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function setUserIdAttribute()
    {
        $this->attributes['user_id'] = Auth::user()->id;
    }
}
