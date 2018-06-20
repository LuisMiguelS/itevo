<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeCourse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
