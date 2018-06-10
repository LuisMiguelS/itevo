<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}
