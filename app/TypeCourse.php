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

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getUrlAttribute()
    {
        return new UrlPresenter($this->branchOffice, $this);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
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
