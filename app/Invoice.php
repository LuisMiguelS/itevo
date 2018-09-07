<?php

namespace App;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use DatesTranslator;

    const STATUS_CANCEL = 'CANCELADO';
    const STATUS_COMPLETE = 'PAGO';
    const STATUS_PENDING = 'PENDIENTE';

    protected $guarded = [];

    protected $appends = ['total', 'balance'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function coursePeriod()
    {
        return $this->morphedByMany(CoursePeriod::class, 'invoicable')->withPivot('price');
    }

    public function resources()
    {
        return $this->morphedByMany(Resource::class, 'invoicable')->withPivot('price');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getTotalAttribute()
    {
        return $this->coursePeriod->sum('price') + $this->resources->sum('price');
    }

    public function getBalanceAttribute()
    {
        return $this->payments->sum('payment_amount');
    }
}
