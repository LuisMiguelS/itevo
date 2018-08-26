<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\CoursePeriod\UrlPresenter;

class CoursePeriod extends Model
{
    use DatesTranslator;

    protected $guarded = [];

    protected $table = 'course_period';

    protected $hidden = ['url'];

    protected $appends = ['url'];

    /**
     * @return \App\Presenters\CoursePeriod\UrlPresenter
     */
    public function getUrlAttribute()
    {
        return new UrlPresenter($this->period->promotion->branchOffice, $this->period, $this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }

    /**
     * @param array $resources
     */
    public function addResources(Array $resources)
    {
        $this->resources()->detach();

        foreach ($resources as $resource_id) {
           $this->onlyIntergerParameter((int) $resource_id);
        }
    }

    /**
     * @param $interger
     */
    public function onlyIntergerParameter($interger)
    {
        if (is_int($interger)){
            $resource = Resource::findOrFail($interger);
            $this->isResource($resource);
        }
    }

    /**
     * @param \App\Resource $resource
     */
    public function isResource(Resource $resource)
    {
        if ($resource) {
            $this->resources()->syncWithoutDetaching($resource);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
