<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'institute_id', 'id_card', 'name', 'last_name', 'phone'
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

    public function course_promotion()
    {
        return $this->hasMany(CoursePromotion::class);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }
}
