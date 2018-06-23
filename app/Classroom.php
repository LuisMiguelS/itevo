<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'name', 'building', 'institute_id'
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setBuildingAttribute($building)
    {
        $this->attributes['building'] = strtolower($building);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getBuildingAttribute($building)
    {
        return ucwords($building);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function scopeOnlyRelations($query, Institute $institute)
    {
        return $query->unless(auth()->user()->isAdmin(), function ($q) use($institute){
            $q->where('institute_id', $institute->id);
        })->orderBy('id','DESC');
    }
}
