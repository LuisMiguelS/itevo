<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use App\Traits\DatesTranslator;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\BranchOffice\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchOffice extends Model
{
    use SoftDeletes, HasSlug, DatesTranslator;

    protected $fillable = [
        'name', 'slug'
    ];

    protected $hidden = [
        'url'
    ];

    protected $appends = ['url'];

    /**
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    /**
     * @param $name
     * @return string
     */
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

    public function getUrlAttribute()
    {
        return new UrlPresenter($this);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_office_user')->withPivot('branch_office_id', 'user_id');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function typeCourses()
    {
        return $this->hasMany(TypeCourse::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function currentPromotion()
    {
        return $this->promotions()->where('status', Promotion::STATUS_CURRENT)->first();
    }
}
