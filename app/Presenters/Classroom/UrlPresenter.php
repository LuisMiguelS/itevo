<?php

namespace App\Presenters\Classroom;

use App\{BranchOffice, Classroom};

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\Classroom
     */
    private $classroom;

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Classroom $classroom
     */
    public function __construct(BranchOffice $branchOffice, Classroom $classroom)
    {

        $this->branchOffice = $branchOffice;
        $this->classroom = $classroom;
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
        return route('tenant.classrooms.edit', [
            'branchOffice' => $this->branchOffice,
            'classroom' => $this->classroom
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.classrooms.update',[
            'branchOffice' => $this->branchOffice,
            'classroom' => $this->classroom
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.classrooms.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'classroom' => $this->classroom
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.classrooms.trash.restore', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->classroom->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.classrooms.destroy', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->classroom->id
        ]);
    }
}
