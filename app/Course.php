<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'name', 'type'
	];

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setTypeAttribute($type)
    {
        $this->attributes['type'] = strtolower($type);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getTypeAttribute($type)
    {
        return ucwords($type);
    }
}
