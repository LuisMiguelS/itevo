<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Teacher\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes, DatesTranslator;

    protected $fillable = [
        'branch_office_id', 'id_card', 'name', 'last_name', 'phone'
    ];

    protected $hidden = [
        'url'
    ];

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
     * @return \App\Presenters\Teacher\UrlPresenter
     */
    public function getUrlAttribute()
    {
        return new UrlPresenter($this->branchOffice, $this);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name. ' '.$this->last_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coursePeriod()
    {
        return $this->hasMany(CoursePeriod::class);
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
