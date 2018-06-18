<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\BouncerFacade as Bouncer;
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
        return Bouncer::is($this)->an(User::ROLE_ADMIN);
    }

    public function institutes()
    {
        return $this->belongsToMany(Institute::class, 'institute_user')->withPivot('institute_id', 'user_id');
    }
}
