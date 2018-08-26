<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use DatesTranslator;

    protected $guarded = [];

    const STATUS_WITHOUT_STARTING = 'sin comenzar';
    const STATUS_CURRENT = 'actual';
    const STATUS_FINISHED = 'terminado';

    const  PERIOD_NO_1 = "Primer periodo";
    const  PERIOD_NO_2 = "Segundo periodo";
    const  PERIOD_NO_3 = "Tercer periodo";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coursePeriods()
    {
        return $this->hasMany(CoursePeriod::class);
    }
}
