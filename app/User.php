<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndAbilities, SoftDeletes, DatesTranslator;

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

    /**
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * @param $name
     * @return string
     */
    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAn(User::ROLE_ADMIN);
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return in_array(
            strtolower($this->email),
            array_map('strtolower', config('itevo.superadmin'))
        );
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return bool
     */
    public function isAssignedTo(BranchOffice $branchOffice): bool
    {
        return $this->branchOffices()->where('branch_office_id', $branchOffice->id)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function branchOffices()
    {
        return $this->belongsToMany(BranchOffice::class, 'branch_office_user')->withPivot('branch_office_id', 'user_id');
    }
}
