<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'period', 'status'
    ];

    const STATUS_WITHOUT_STARTING = 'sin comenzar';
    const STATUS_CURRENT = 'actual';
    const STATUS_FINISHED = 'terminado';

    const  PERIOD_NO_1 = "Cuatrimestre 1";
    const  PERIOD_NO_2 = "Cuatrimestre 2";
    const  PERIOD_NO_3 = "Cuatrimestre 3";

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
