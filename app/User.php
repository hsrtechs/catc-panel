<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class User
 * @property mixed available_cpu
 * @property mixed max_cpu
 * @property mixed available_ram
 * @property mixed max_ram
 * @property mixed available_storage
 * @property mixed max_storage
 * @package App
 */
class User extends Authenticatable
{

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $table = "users";

    /**
     * Hidden fields for the form
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Describing the fields that can be mass assigned.
     * @var $fillable array
     */

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'max_cpu',
        'max_storage',
        'max_ram',
        'available_cpu',
        'available_storage',
        'available_ram',
        'user_assoc',
        'role_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'role_id' => 'int',
        'name' => 'string',
        'max_ram' => 'int',
        'max_cpu' => 'int',
        'max_storage' => 'int',
        'available_ram' => 'int',
        'available_cpu' => 'int',
        'available_storage' => 'int',
    ];

    /**
     * @var array
     */
    protected $appends = ['cpu_percentage', 'ram_percentage', 'storage_percentage'];

    /**
     * Changing the key for the route parameters for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     *
     */

    /**
     * Finding the Roles of the USERS
     */

    public function users()
    {
        return $this->all();
    }

    /**
     * @return int
     */
    public function getAdminsCount()
    {
        return $this->all()->where('role_id', 1)->count();
    }

    /**
     * @return int
     */
    public function getModsCount()
    {
        return $this->all()->where('role_id', 2)->count();
    }

    /**
     * @return int
     */
    public function getResellersCount()
    {
        return $this->all()->where('role_id', 3)->count();
    }

    /**
     * @return int
     */
    public function getSuspendedCount()
    {
        return $this->all()->where('role_id', 9)->count();
    }

    /**
     * @return int
     */
    public function getTerminatedCount()
    {
        return $this->all()->where('role_id', 10)->count();
    }

    /**
     * @return int
     */
    public function getNormalUsersCount()
    {
        return $this->all()->where('role_id', 4)->count();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('Administrator');
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->role()->where('name', $role)->get()->count()) {
            return true;
        }
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * @return bool
     */
    public function isMod()
    {
        return $this->hasRole('Moderator');
    }

    /**
     * @return bool
     */
    public function isReseller()
    {
        return $this->hasRole('Reseller');
    }

    /**
     * @param $permissions
     * @return bool
     */
    public function hasAnyPermission($permissions)
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                if ($this->hasPermission($permission)) {
                    return true;
                }
            }
        } elseif ($this->hasPermission($permissions)) {
            return true;
        }

        return false;
    }

    // Accessors

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->permissions()->where('name', $permission)->get()->count()) {
            return true;
        }
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'user_permissions');
    }

    /**
     * @return float
     */
    public function getCpuPercentageAttribute()
    {
        return $this->available_cpu * 100 / $this->max_cpu;
    }

    //Mutators
    // Setting the Attributes after getting them from database

    /**
     * @return float
     */
    public function getRamPercentageAttribute()
    {
        return $this->available_ram * 100 / $this->max_ram;
    }

    /**
     * @return float
     */
    public function getStoragePercentageAttribute()
    {
        return $this->available_storage * 100 / $this->max_storage;
    }


    //Relationships

    /**
     * @param null $value
     */
    public function setRoleIdAttribute($value = NULL)
    {
        $this->attributes['role_id'] = (isset($value)) ? $value : 4;
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userReseller()
    {
        return $this->belongsTo('App\User', 'user_assoc', 'id');
    }

    /**
     * @param $value
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    /**
     * @param null $value
     */
    public function setUserAssocAttribute($value = NULL)
    {
        $this->attributes['user_assoc'] = (!is_null($value)) ? $value : Auth::user()->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    /**
     * @param null $id
     * @return boolean
     */

    public function ownsServerScope($id = NULL)
    {
        if ($this->getUserServers()->where('id', $id)->get()->count()) {
            return true;
        }
        return false;
    }

    // Query Scopes

    /**
     * Return all the servers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUserServers()
    {
        return $this->hasMany('App\Server')->get()->sortBy('id');
    }

    /**
     * @param $permission
     */
    public function hasPermissionScope($permission)
    {
        $this->permissions()->get()->where('name', $permission);
    }
}
