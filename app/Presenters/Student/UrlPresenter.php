<?php

namespace App\Presenters\Student;

use App\BranchOffice;
use App\Student;

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\Student
     */
    private $student;

    public function __construct(BranchOffice $branchOffice, Student $student)
    {
        $this->branchOffice = $branchOffice;
        $this->student = $student;
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
        return route('tenant.students.destroy', [
            'branchOffice' => $this->branchOffice,
            'student' => $this->student
        ]);
    }

    public function edit()
    {
        return route('tenant.students.edit', [
            'branchOffice' => $this->branchOffice,
            'student' => $this->student
        ]);
    }

    public function update()
    {
        return route('tenant.students.update',[
            'branchOffice' => $this->branchOffice,
            'student' => $this->student
        ]);
    }
}
