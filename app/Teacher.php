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

    protected $appends = ['url'];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setLastNameAttribute($last_name)
    {
        $this->attributes['last_name'] = strtolower($last_name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getLastNameAttribute($last_name)
    {
        return ucwords($last_name);
    }

    public function getUrlAttribute()
    {
        return new UrlPresenter($this->branchOffice, $this);
    }

    public function getFullNameAttribute()
    {
        return $this->name. ' '.$this->last_name;
    }

    public function course_promotion()
    {
        return $this->hasMany(CoursePromotion::class);
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function isRegisteredIn(BranchOffice $branchOffice)
    {
        return $this->branchOffice()->where('id', $branchOffice->id)->count() > 0;
    }
}
