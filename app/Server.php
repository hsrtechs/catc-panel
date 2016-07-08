<?php namespace App;


use Faker;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 * @property mixed owner
 * @property mixed cpu
 * @property mixed ram
 * @property mixed storage
 * @property mixed created_at
 * @property mixed user_id
 * @property mixed id
 * @package App
 */
class
Server extends Model
{
    /**
     * Describing the Table Name
     * @var $table String
     */
    protected $table = "servers";

    /**
     * Describing the fields that can be mass assigned.
     * @var $fillable array
     */
    protected $fillable = [
        'cpu',
        'ram',
        'storage',
        'os',
        'ip',
        'user_id',
        'sid',
        'used_ram',
        'used_cpu',
        'used_storage',
        'rdns',
        'root_pass',
        'vnc_port',
        'vnc_pass',
        'status',
        'mode',
        'desc',
        'label',
        'name'
    ];
    protected $casts = [
        'cpu' => 'int',
        'ram' => 'int',
        'storage' => 'int',
        'os' => 'int',
        'ip' => 'int',
        'user_id' => 'int',
        'sid' => 'int',
        'used_ram' => 'float',
        'used_cpu' => 'float',
        'used_storage' => 'float',
        'vnc_port' => 'int',
    ];

    /**
     * Return the Server owner
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    public function owner()
    {
        return $this->belongsTo('App\User');
    }
    public function setOsAttribute($value)
    {
        $data = self::templates();
        $this->attributes['os'] = array_flip($data)[($value)];
    }
    public function setIpAttribute($value){
        $this->attributes['ip'] = ip2long($value);
    }
    public function setStatusAttribute($value)
    {
        $status = [-1 => 'Installing', 0 => "Powered Off", 1 => "Powered On"];
//        dd(array_flip($status)[$value]);
        $this->attributes['status'] = array_flip($status)[$value];
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function setModeAttribute($value)
    {
        $this->attributes['mode'] =  ($value === 'Normal') ? 1 : 0;
    }


    /**
     * @param $value
     *
     * @return mixed
     */
    public function setUsedCpuAttribute($value)
    {
        $this->attributes['used_cpu'] =  json_encode($value);
    }


    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return float
     */
    public function setUsedRamAttribute($value)
    {
        $this->attributes['used_ram'] =  json_encode($value);
    }

    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return float
     */
    public function setUsedStorageAttribute($value)
    {
        $this->attributes['used_storage'] =  json_encode($value);
    }

    /**
     * Create a Label if not exists
     *
     * @param $value
     * @return string
     */
    public function getLabelAttribute($value)
    {
        $faker = Faker\Factory::create()->name;
        return (empty($value)) ? $faker : ucwords($value);
    }

    /**
     * @param $value
     *
     * @return mixed|string
     */
    public function getOsAttribute($value)
    {
        $data = self::templates();
        if (!array_key_exists($value, $data)) {
            return 'Invalid OS';
        }

        return $data[$value];
    }

    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return integer
     */
    public function getCpuAttribute($value)
    {
        return ($value);
    }

    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return string
     */
    public function getRamAttribute($value)
    {
        return ($value);
    }


    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return string
     */
    public function getStorageAttribute($value)
    {
        return ($value);
    }


    /**
     * @param $value
     *
     * @return mixed
     */
    public function getUsedCpuAttribute($value)
    {
        return (json_decode($value));
    }


    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return float
     */
    public function getUsedRamAttribute($value)
    {
        return (json_decode($value));
    }

    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return float
     */
    public function getUsedStorageAttribute($value)
    {
        return (json_decode($value));
    }


    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return float
     */
    public function getStatusAttribute($value)
    {
        $status = [-1 => 'Under Installation', 0 => "Powered Off", 1 => 'Powered On'];
        return $status[$value];
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getIpAttribute($value)
    {
        return long2ip($value);
    }

    public function logs()
    {
        return $this->hasMany('App\Task');
    }

    public static function templates(){
        return json_decode("{\"1\":\"CentOS 6.7 64bit\",\"3\":\"Debian-8-64bit\",\"9\":\"Windows 7 64bit\",\"24\":\"Windows 2008 R2 64bit\",\"25\":\"Windows 2012 R2 64bit\",\"26\":\"CentOS-7-64bit\",\"27\":\"Ubuntu-14.04.1-LTS-64bit\",\"28\":\"Minecraft-CentOS-7-64bit\",\"74\":\"FreeBSD-10-1-64bit\",\"75\":\"Docker-64bit\"}",true);
    }

    public static function completeArray($array = [], $length = 10){
        if(!is_array($array)){
            $array = json_decode($array,true);
        }
        if(count($array) < $length){
            $array = array_reverse($array);
            while(count($array) < $length){
                array_push($array,0);
            }return array_reverse($array);
        }else return $array;
    }

}
