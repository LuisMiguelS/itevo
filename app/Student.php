<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Student\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes, DatesTranslator;

    protected $guarded = [];

    protected $hidden = ['url'];

    protected $appends = ['url', 'full_name'];

    /**
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    /**
     * @param $last_name
     */
    public function setLastNameAttribute($last_name)
    {
        $this->attributes['last_name'] = strtolower($last_name);
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
     * @param $last_name
     * @return string
     */
    public function getLastNameAttribute($last_name)
    {
        return ucwords($last_name);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name. ' '.$this->last_name;
    }

    /**
     * @return \App\Presenters\Student\UrlPresenter
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coursePeriod()
    {
        return $this->belongsToMany(CoursePeriod::class);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return bool
     */
    public function isRegisteredIn(BranchOffice $branchOffice)
    {
        return $this->branchOffice()->where('id', $branchOffice->id)->count() > 0;
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
