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
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function Servers()
    {
        if($this->isAdmin() || $this->isMod())
        {
            return Server::all();
        }elseif ($this->isReseller())
        {
            return $this->getUserServers->merge($this->getSubUserServers);
        }elseif ($this->isNormalUser())
        {
            return $this->getUserServers;
        }
    }

    /**
     * @return mixed
     */
    public function Tickets()
    {
        if($this->isAdmin())
        {
            return Ticket::ActiveTickets();
        }elseif($this->isMod())
        {
            if($this->hasPermission('Tickets'))
            {
                return $this->getSubUserTickets->merge($this->getTickets);
            }else{
                return $this->getTickets;
            }
        }elseif ($this->isReseller())
        {
            return $this->getSubUserTickets->merge($this->getTickets);
        }elseif ($this->isNormalUser())
        {
            return $this->getTickets;
        }
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
     * @return bool
     */
    public function isActivated()
    {
        return $this->role_id === 0;
    }


    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('Administrator');
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
     * @return bool
     */
    public function isNormalUser()
    {
        return $this->hasRole('User');
    }

    /**
     * @return bool
     */
    public function isSuspended()
    {
        return $this->hasRole('Suspended');
    }

    /**
     * @return bool
     */
    public function isTerminated()
    {
        return $this->hasRole('Terminated');
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

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } elseif ($this->hasRole($roles)) {
            return true;
        }

        return false;
    }

    /**
     * @param $resources
     * @return bool
     */
    public function checkResources($resources)
    {
        if($this->available_cpu >= $resources['cpu'] && $this->available_ram >= $resources['ram'] && $this->available_storage >= $resources['storage'])
        {
            return true;
        }
        return false;
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->permissions()->where('name', $permission)->count()) {
            return true;
        }
        return false;
    }
    /**
     * @param $permissions
     * @return bool
     */
    public function hasAnyDepartment($departments)
    {
        if (is_array($departments)) {
            foreach ($departments as $department) {
                if ($this->hasDepartment($department)) {
                    return true;
                }
            }
        } elseif ($this->hasDepartment($departments)) {
            return true;
        }

        return false;
    }

    /**
     * @param $department
     * @return boolean
     */
    public function hasDepartment($department)
    {
        if ($this->department()->where('name', $department)->get()->count()) {
            return true;
        }
        return false;
    }

    // Accessors

    /**
     * @return float
     */
    public function getCpuPercentageAttribute()
    {
        return is_null($this->available_cpu) ? 0 : $this->available_cpu * 100 / $this->max_cpu;
    }

    //Mutaters
    // Setting the Attributes after getting them from database

    /**
     * @return float
     */
    public function getRamPercentageAttribute()
    {
        return is_null($this->available_cpu) ? 0 : $this->available_ram * 100 / $this->max_ram;
    }

    /**
     * @return float
     */
    public function getStoragePercentageAttribute()
    {
        return is_null($this->available_cpu) ? 0 : $this->available_storage * 100 / $this->max_storage;
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
        $this->attributes['user_assoc'] = (!is_null($value)) ? $value : 0;
    }

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function department(){
        return $this->belongsToMany('App\Department','users_departments');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'users_permissions');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userReseller()
    {
        return $this->belongsTo('App\User','user_assoc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getSubUsers(){
        return $this->hasMany('App\User', 'user_assoc');
    }
    /**
     * Finding tickets a belongs to users
     */

    public function getSubUserTickets()
    {
        return $this->hasManyThrough('App\Ticket','App\User','user_assoc');
    }
    /**
     * Finding Servers a belongs to users
     */

    public function getSubUserServers()
    {
        return $this->hasManyThrough('App\Server','App\User','user_assoc');
    }

    /**
     * Finding tickets a belongs to Departments
     */

    public function getDepartmentTickets()
    {
        return $this->hasManyThrough('App\Ticket','App\Department','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getTickets()
    {
        return $this->hasMany('App\Ticket');
    }

    /**
     * Return all the servers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUserServers()
    {
        return $this->hasMany('App\Server');
    }
    /**
     * @param null $id
     * @return boolean
     */


    // Query Scopes


    /**
     * @return bool
     */
    public function hasResources()
    {
        return !($this->available_cpu > 0 && $this->available_storage > 10 && $this->available_ram > 512);
    }

    /**
     * @param null $id
     * @return bool
     */
    public function scopeOwnsServer($id = NULL)
    {
        if ($this->getUserServers->where('id', $id)->count() || $this->isAdmin() || $this->isMod())
        {
            return true;
        }else if($this->isReseller() && $this->getSubUserServers->where('id',$id)->count())
        {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function scopeServers(){
        return $this->getUserServers->sortBy('id');
    }

    /**
     * @param $permission
     */
    public function scopeHasPermission($permission)
    {
        $this->permissions()->get()->where('name', $permission);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function scopeUsers()
    {
        return $this->all();
    }


    /**
     * @return mixed
     */
    public function scopeActiveUsers()
    {
        return $this->where('role_id','!=',0)->where('role_id','!=',9)->where('role_id','!=',10)->get();
    }

}
