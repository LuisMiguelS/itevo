<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\Classroom\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'name', 'building', 'branch_office_id'
    ];

    protected $hidden = [
        'url'
    ];

    protected $appends = ['url'];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setBuildingAttribute($building)
    {
        $this->attributes['building'] = strtolower($building);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function getBuildingAttribute($building)
    {
        return ucwords($building);
    }

    public function getUrlAttribute()
    {
        return new UrlPresenter($this->branchOffice, $this);
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
