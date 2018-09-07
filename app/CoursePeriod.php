<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\CoursePeriod\UrlPresenter;
use Illuminate\Support\Collection;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(Student::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class);
    }

    public function addSchedules($request)
    {
        $this->schedules()->detach();

        foreach ($request as $schedule_id) {
            $schedule = Schedule::find($schedule_id);

            if ($schedule) {
                $course = $this->haveSameWeekday($schedule);

                if ($course->isNotEmpty() && $course->first()->isNotEmpty()) {
                    foreach ($course->first() as $course_schedule) {
                        if (! ($course_schedule->start_at->toTimeString() >= $schedule->start_at->toTimeString() && $course_schedule->ends_at->toTimeString() <= $schedule->ends_at->toTimeString())) {
                            $this->schedules()->syncWithoutDetaching($schedule->id);
                        }
                    }
                }else {
                    $this->schedules()->syncWithoutDetaching($schedule->id);
                }
            }
        }


    }

    public function haveSameWeekday($schedule)
    {
        return $this->getCurrentCourses()->map(function ($object) use ($schedule){
            return $object->schedules()->where('weekday', $schedule->weekday)->get();
        });
    }

    public function getCurrentCourses()
    {
        return  collect($this->period->coursePeriods()->where('id', '<>', $this->id)->get());
    }

    public function invoices()
    {
        return $this->morphToMany(Invoice::class, 'invoicable');
    }
}
