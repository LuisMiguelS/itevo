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
        return $this->morphedByMany(Student::class, 'coursable');
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
        return $this->morphedByMany(Resource::class, 'coursable');
    }

    /**
     * @param array $resources
     */
    public function addResources(Array $resources)
    {
        $this->resources()->detach();

        collect($resources)->filter(function ($object) {
           if (is_int( (int) $object)) return $object;
        })->each(function ($resource_id) {
            $resource = Resource::findOrFail($resource_id);
            $this->resources()->syncWithoutDetaching($resource);
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schedules()
    {
        return $this->morphedByMany(Schedule::class, 'coursable');
    }

    public function addSchedules($schedules)
    {
        $this->schedules()->detach();

        collect($schedules)->each(function ($schedule_id) {
            tap(Schedule::find($schedule_id), function(Schedule $schedule) {
                tap($this->haveSameWeekday($schedule), function ($courses) use($schedule) {
                    if ($courses->collapse()->isNotEmpty()) {
                        $courses->collapse()->each(function ($course) use($schedule) {
                            if (! ($course->start_at->toTimeString() >= $schedule->start_at->toTimeString()
                                && $course->ends_at->toTimeString() <= $schedule->ends_at->toTimeString())) {
                                $this->schedules()->syncWithoutDetaching($schedule->id);
                            }
                        });
                        return;
                    }
                    $this->schedules()->syncWithoutDetaching($schedule->id);
                });
            });
        });

    }

    public function haveSameWeekday($schedule)
    {
        return $this->getCurrentCourses()->map(function ($object) use ($schedule){
            return $object->schedules()->where('weekday', $schedule->weekday)->get();
        });
    }

    public function getCurrentCourses()
    {
        return  collect($this->period->coursePeriods()
            ->where('id', '<>', $this->id)
            ->where('classroom_id', $this->classroom_id)
            ->get());
    }

    public function invoices()
    {
        return $this->morphToMany(Invoice::class, 'invoicable');
    }
}
