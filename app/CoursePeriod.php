<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursePeriod extends Model
{
    protected $guarded = [];

    protected $table = 'course_period';

    public function period()
    {
        return $this->belongsTo(Period::class);
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
