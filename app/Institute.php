<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class institute extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}
