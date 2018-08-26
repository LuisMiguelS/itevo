<?php

namespace App\Presenters\CoursePeriod;

use App\{BranchOffice, CoursePeriod, Period};

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\Period
     */
    private $period;

    /**
     * @var \App\CoursePeriod
     */
    private $coursePeriod;

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Period $period
     * @param \App\CoursePeriod $coursePeriod
     */
    public function __construct(BranchOffice $branchOffice, Period $period, CoursePeriod $coursePeriod)
    {
        $this->branchOffice = $branchOffice;
        $this->period = $period;
        $this->coursePeriod = $coursePeriod;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->$key();
        }

        return $this->$key;
    }

    /**
     * @return string
     */
    public function edit()
    {
        return route('tenant.periods.course-period.edit', [
            'branchOffice' => $this->branchOffice,
            'period' => $this->period,
            'coursePeriod' => $this->coursePeriod
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.periods.course-period.update',[
            'branchOffice' => $this->branchOffice,
            'period' => $this->period,
            'coursePeriod' => $this->coursePeriod
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.periods.course-period.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'period' => $this->period,
            'coursePeriod' => $this->coursePeriod
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.periods.course-period.restore', [
            'branchOffice' => $this->branchOffice,
            'period' => $this->period,
            'id' => $this->coursePeriod->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.periods.course-period.destroy', [
            'branchOffice' => $this->branchOffice,
            'period' => $this->period,
            'id' => $this->coursePeriod->id
        ]);
    }

    public function resource()
    {
        return route('tenant.periods.course-period.resources.index', [
            'branchOffice' => $this->branchOffice,
            'period' => $this->period,
            'id' => $this->coursePeriod->id
        ]);
    }

    public function addResource()
    {
        return route('tenant.periods.course-period.resources', [
            'branchOffice' => $this->branchOffice,
            'period' => $this->period,
            'id' => $this->coursePeriod->id
        ]);
    }
}
