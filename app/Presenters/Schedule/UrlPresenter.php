<?php

namespace App\Presenters\Schedule;

use App\{BranchOffice, Schedule};

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\Schedule
     */
    private $schedule;

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Schedule $schedule
     */
    public function __construct(BranchOffice $branchOffice, Schedule $schedule)
    {

        $this->branchOffice = $branchOffice;
        $this->schedule = $schedule;
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
        return route('tenant.schedules.edit', [
            'branchOffice' => $this->branchOffice,
            'schedule' => $this->schedule
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.schedules.update',[
            'branchOffice' => $this->branchOffice,
            'schedule' => $this->schedule
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.schedules.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'schedule' => $this->schedule
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.schedules.trash.restore', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->schedule->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.schedules.destroy', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->schedule->id
        ]);
    }
}
