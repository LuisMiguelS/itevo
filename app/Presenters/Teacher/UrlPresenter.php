<?php

namespace App\Presenters\Teacher;

use App\{BranchOffice, Teacher};

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\Teacher
     */
    private $teacher;

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Teacher $teacher
     */
    public function __construct(BranchOffice $branchOffice, Teacher $teacher)
    {
        $this->branchOffice = $branchOffice;
        $this->teacher = $teacher;
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
        return route('tenant.teachers.edit', [
            'branchOffice' => $this->branchOffice,
            'teacher' => $this->teacher
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.teachers.update',[
            'branchOffice' => $this->branchOffice,
            'teacher' => $this->teacher
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.teachers.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'teacher' => $this->teacher
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.teachers.trash.restore', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->teacher->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.teachers.destroy', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->teacher->id
        ]);
    }
}
