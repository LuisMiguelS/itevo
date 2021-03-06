<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Schedule\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use DatesTranslator, SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['url'];

    protected $appends = ['url'];

    const WEEKDAY = [
      'monday' => 'lunes',
      'tuesday' => 'martes',
      'wednesday' => 'miercoles',
      'thursday' => 'jueves',
      'friday' => 'viernes',
      'saturday' => 'sabado',
      'sunday' => 'domingo',
    ];

    /**
     * @return \App\Presenters\Schedule\UrlPresenter
     */
    public function getUrlAttribute()
    {
        return new UrlPresenter($this->branchOffice, $this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coursePeriods()
    {
        return $this->morphToMany(CoursePeriod::class, 'coursable');
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return bool
     */
    public function isRegisteredIn(BranchOffice $branchOffice)
    {
        return $this->branchOffice()->where('id', $branchOffice->id)->count() > 0;
    }
}
