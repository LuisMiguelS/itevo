<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function course_promotion()
    {
        return $this->hasMany(CoursePromotion::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
