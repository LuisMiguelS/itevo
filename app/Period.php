<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'period', 'status', 'start_date_at', 'ends_at'
    ];

    const STATUS_WITHOUT_STARTING = 'sin comenzar';
    const STATUS_CURRENT = 'actual';
    const STATUS_FINISHED = 'terminado';

    const  PERIOD_NO_1 = "Primer cuatrimestre";
    const  PERIOD_NO_2 = "Segundo Cuatrimestre";
    const  PERIOD_NO_3 = "Tercer Cuatrimestre";

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
