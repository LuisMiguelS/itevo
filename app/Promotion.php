<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Promotion\UrlPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes, DatesTranslator;

    protected $fillable = [
        'promotion_no', 'status'
    ];

    protected $hidden = [
        'url'
    ];

    protected $appends = ['url'];

    const STATUS_CURRENT = 'actual';
    const STATUS_FINISHED = 'terminado';

    public function getUrlAttribute()
    {
        return new UrlPresenter($this->branchOffice, $this);
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function coursePromotions()
    {
        return $this->hasMany(CoursePeriod::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function periods()
    {
        return $this->hasMany(Period::class);
    }

    public function isRegisteredIn(BranchOffice $branchOffice)
    {
        return $this->branchOffice()->where('id', $branchOffice->id)->count() > 0;
    }

    public function currentPeriod()
    {
        return $this->periods()->where('status', Period::STATUS_CURRENT)->first();
    }
}
