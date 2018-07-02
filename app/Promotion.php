<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    const STATUS_INSCRIPTION = 'inscripción';
    const STATUS_CURRENT = 'corriente';
    const STATUS_FINISHED = 'terminado';

    const PROMOTION_NO_1 = 1;
    const PROMOTION_NO_2 = 2;
    const PROMOTION_NO_3 = 3;

    protected $guarded = [];

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function coursePromotions()
    {
        return $this->hasMany(CoursePromotion::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
