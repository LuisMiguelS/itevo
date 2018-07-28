<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'branch_office_id',
        'promotion_id',
        'name',
        'last_name',
        'id_card',
        'phone',
        'address',
        'is_adult',
        'tutor_id_card',
        'birthdate',
        'signed_up'
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setLastNameAttribute($last_name)
    {
        $this->attributes['last_name'] = strtolower($last_name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getLastNameAttribute($last_name)
    {
        return ucwords($last_name);
    }

    public function getFullNameAttribute()
    {
        return $this->name. ' '.$this->last_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course_promotion()
    {
        return $this->hasMany(CoursePromotion::class);
    }
}
