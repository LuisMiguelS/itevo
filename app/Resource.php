<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Resource\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
	use SoftDeletes, DatesTranslator;

	protected $guarded = [];

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
     * @return \App\Presenters\Resource\UrlPresenter
     */
    public function getUrlAttribute()
    {
        return new UrlPresenter($this->branchOffice, $this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coursePeriod()
    {
        return $this->belongsToMany(CoursePeriod::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
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
