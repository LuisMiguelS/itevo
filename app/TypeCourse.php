<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\TypeCourse\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeCourse extends Model
{
    use SoftDeletes, DatesTranslator;

    protected $fillable = [
        'name', 'branch_office_id'
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
     * @return \App\Presenters\TypeCourse\UrlPresenter
     */
    public function getUrlAttribute()
    {
        return new UrlPresenter($this->branchOffice, $this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
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
