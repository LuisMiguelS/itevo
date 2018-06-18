<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'name'
	];

    public function course_promotion()
    {
        return $this->hasMany(CoursePromotion::class);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }
	
	public function getNameAttribute($name)
    {
        return ucwords($name);
    }
}
