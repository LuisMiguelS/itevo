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

    /**
     * @return \App\Presenters\Promotion\UrlPresenter
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periods()
    {
        return $this->hasMany(Period::class);
    }

    /**
     * @param \App\BranchOffice $branchOffice
     * @return bool
     */
    public function isRegisteredIn(BranchOffice $branchOffice)
    {
        return $this->branchOffice()->where('id', $branchOffice->id)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|null|object
     */
    public function currentPeriod()
    {
        return $this->periods()->where('status', Period::STATUS_CURRENT)->first();
    }
}
