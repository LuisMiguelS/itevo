<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Classroom\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
	use SoftDeletes, DatesTranslator;

    protected $fillable = [
    	'name', 'building', 'branch_office_id'
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
     * @param $building
     */
    public function setBuildingAttribute($building)
    {
        $this->attributes['building'] = strtolower($building);
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
     * @param $building
     * @return string
     */
    public function getBuildingAttribute($building)
    {
        return ucwords($building);
    }

    /**
     * @return \App\Presenters\Classroom\UrlPresenter
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coursePeriod()
    {
        return $this->hasMany(CoursePeriod::class);
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
