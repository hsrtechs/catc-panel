<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class User
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
     * Changing the key for the route parameters for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Finding the Roles of the USERS
     */

    public function users()
    {
        return $this->all();
    }

    public function getAdminsCount()
    {
        return $this->all()->where('role_id', 1)->count();
    }

    public function getModsCount()
    {
        return $this->all()->where('role_id', 2)->count();
    }

    public function getResellersCount()
    {
        return $this->all()->where('role_id', 3)->count();
    }

    public function getSuspendedCount()
    {
        return $this->all()->where('role_id', 9)->count();
    }

    public function getTerminatedCount()
    {
        return $this->all()->where('role_id', 10)->count();
    }

    public function getNormalUsersCount()
    {
        return $this->all()->where('role_id', 4)->count();
    }

    public function isAdmin()
    {
        return $this->hasRole('Administrator');
    }

    public function hasRole($role)
    {
        if ($this->role()->where('name', $role)->get()->count()) {
            return true;
        }
        return false;
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function isMod()
    {
        return $this->hasRole('Moderator');
    }

    public function isReseller()
    {
        return $this->hasRole('Reseller');
    }

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


    //Mutators
    // Setting the Attributes after getting them from database

    public function hasPermission($permission)
    {
        if ($this->permissions()->where('name', $permission)->get()->count()) {
            return true;
        }
        return false;
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'user_permissions');
    }

    public function setRoleIdAttribute($value = NULL)
    {
        $this->attributes['role_id'] = (isset($value)) ? $value : 4;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    //Relationships

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    public function setUserAssocAttribute($value = NULL)
    {
        $this->attributes['user_assoc'] = (!is_null($value)) ? $value : Auth::user()->id;
    }

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

    public function hasPermissionScope($permission)
    {
        $this->permissions()->get()->where('name', $permission);
    }
}
