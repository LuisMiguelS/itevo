<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institute extends Model
{
    use SoftDeletes, HasSlug;

    protected $fillable = [
        'name', 'slug'
    ];


    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }


    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'institute_user')->withPivot('institute_id', 'user_id');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function scopeOnlyRelations($query, Institute $institute = null)
    {
        return $query->unless(auth()->user()->isAdmin(), function ($q) use($institute){
            $q->where('id', $institute->id);
        })->orderBy('id','DESC');
    }
}
