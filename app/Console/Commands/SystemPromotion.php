<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\{Institute, Promotion};
use Illuminate\Console\Command;

class SystemPromotion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the corresponding promotions of the institutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       tap(Carbon::now(), function ($dataNow) {
           $this->firstPeriod($dataNow);
           $this->secondPeriod($dataNow);
           $this->thirdPeriod($dataNow);
       });
    }

    protected function firstPeriod(Carbon $dataNow)
    {
        if ($dataNow->between(new Carbon('January 1'), new Carbon('April 30'))) {
            $this->createPeriod(Promotion::PROMOTION_NO_1);
            $this->verifyInscription($dataNow, 'January 15');
        }
    }

    protected function secondPeriod(Carbon $dataNow)
    {
        if ($dataNow->between(new Carbon('May 1'), new Carbon('August 30'))){
            $this->createPeriod(Promotion::PROMOTION_NO_2);
            $this->verifyInscription($dataNow, 'May 15');
        }
    }

    protected function thirdPeriod(Carbon $dataNow)
    {
        if ($dataNow->between(new Carbon('September 1'), new Carbon('December 30'))){
            $this->createPeriod(Promotion::PROMOTION_NO_3);
            $this->verifyInscription($dataNow, 'September 15');
        }
    }

    protected function createPeriod($periodo)
    {
        foreach (Institute::all() as $institute){
            if ($this->isNotPromotionPeriodInCurrentInstitute($institute, $periodo)) {
                $this->changeStatusToFinish($institute);
                $institute->promotions()->create([
                    'period' => $periodo
                ]);
            }
        }
    }

    protected function isNotPromotionPeriodInCurrentInstitute(Institute $institute, $periodo)
    {
        return !$institute->promotions()
            ->where('period', $periodo)
            ->whereYear('created_at', Carbon::now()->year)->count() > 0;
    }

    protected function changeStatusToFinish(Institute $institute)
    {
        tap($institute->promotions()->where('status', Promotion::STATUS_CURRENT)->orWhere('status', Promotion::STATUS_INSCRIPTION)->get()->last(), function ($promocion) {
            if ($promocion !== null) {
                $promocion->status = Promotion::STATUS_FINISHED;
                $promocion->save();
            }
        });
    }

    protected function verifyInscription(Carbon $dataNow, $finishData)
    {
        if ($this->isInscripcionEnded($dataNow,$finishData)){
            $this->changeStatusToCurrent();
        }
    }

    protected function isInscripcionEnded(Carbon $dataNow, $finishData)
    {
        return $dataNow->greaterThan(new Carbon($finishData));
    }

    protected function changeStatusToCurrent()
    {
        foreach (Institute::all() as $institute){
            tap($institute->promotions()->where('status', Promotion::STATUS_INSCRIPTION)->get()->last(), function ($promocion) {
                if ($promocion !== null) {
                    $promocion->status = Promotion::STATUS_CURRENT;
                    $promocion->save();
                }
            });
        }
    }

}
