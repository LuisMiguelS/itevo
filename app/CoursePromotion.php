<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursePromotion extends Model
{
    protected $table = 'course_promotion';

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function resource()
    {
        return $this->hasMany(Resource::class);
    }
}
