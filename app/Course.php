<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'name', 'type_course_id'
	];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function typecourse()
    {
        return $this->belongsTo(TypeCourse::class, 'type_course_id');
    }

    public function coursePromotion()
    {
        return $this->hasMany(CoursePromotion::class);
    }
}
