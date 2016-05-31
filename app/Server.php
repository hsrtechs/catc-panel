<?php namespace App;

use Carbon\Carbon;
use Faker;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 * @property mixed owner
 * @property mixed cpu
 * @property mixed ram
 * @property mixed storage
 * @property mixed created_at
 * @package App
 */
class Server extends Model
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
        'label'
    ];

    /**
     * Return the Server owner
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function owner()
    {
        return $this->belongsTo('App\User');
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
        $data = [
            26 => "CentOS-7-64bit",
            27 => "Ubuntu-14.04.1-LTS-64bit",
            15 => "CentOS 6.5 64bit (LAMP)",
            21 => "Ubuntu 12.10 64bit",
            23 => "Ubuntu 12.04.3 LTS 64bit",
            24 => "Windows 2008 R2 64bit (BigDogs Only)",
            25 => "Windows 2012 R2 64bit (BigDogs Only)",
            14 => "CentOS 6.5 64bit (cPanel-WHM)",
            13 => "CentOS 6.5 64bit",
            10 => "CentOS 6.5 32bit",
            3 => "Debian 7.1 64bit",
            9 => "Windows7 64bit (BigDogs Only)",
            2 => "Ubuntu-13.10-64bit",
            1 => "CentOS 6.4 64bit",
            28 => "Minecraft-CentOS-7-64bit",
        ];
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
        return ($value) . ' MB';
    }
    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return string
     */
    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return string
     */
    public function getStorageAttribute($value)
    {
        return ($value) . ' GB';
    }


    /**
     * @param $value
     *
     * @return mixed
     */
    public function getUsedCpuAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return float
     */
    public function getStatusAttribute($value)
    {
        $status = [-1 => 'Under Installation', 0 => "Powered Off", 1 => 'Powered ON'];
        return $status[$value];
    }


    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return float
     */
    public function getUsedRamAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Returning the usable value for the views.
     *
     * @param $value
     * @return float
     */
    public function getUsedStorageAttribute($value)
    {
        return json_decode($value);
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

}
