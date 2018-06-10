<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    public function course_promotion()
    {
        return $this->hasMany(CoursePromotion::class);
    }
}
