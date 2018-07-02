<?php

namespace App\Presenters\Teacher;

use App\BranchOffice;
use App\Teacher;

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

    public function __construct(BranchOffice $branchOffice, Teacher $teacher)
    {
        $this->branchOffice = $branchOffice;
        $this->teacher = $teacher;
    }

    public function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->$key();
        }

        return $this->$key;
    }

    public function delete()
    {
        return route('tenant.teachers.destroy', [
            'branchOffice' => $this->branchOffice,
            'teacher' => $this->teacher
        ]);
    }

    public function edit()
    {
        return route('tenant.teachers.edit', [
            'branchOffice' => $this->branchOffice,
            'teacher' => $this->teacher
        ]);
    }

    public function update()
    {
        return route('tenant.teachers.update',[
            'branchOffice' => $this->branchOffice,
            'teacher' => $this->teacher
        ]);
    }
}
