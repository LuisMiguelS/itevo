<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndAbilities, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_TENANT_ADMIN = 'tenant admin';

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function isAdmin()
    {
        return $this->isAn(User::ROLE_ADMIN);
    }

    public function isAssignedTo(Institute $institute): bool
    {
        return $this->institutes()->where('institute_id', $institute->id)->count() > 0;
    }

    public function institutes()
    {
        return $this->belongsToMany(Institute::class, 'institute_user')->withPivot('institute_id', 'user_id');
    }
}
