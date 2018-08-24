<?php

namespace App\Presenters\Student;

use App\{BranchOffice, Student};

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

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Student $student
     */
    public function __construct(BranchOffice $branchOffice, Student $student)
    {
        $this->branchOffice = $branchOffice;
        $this->student = $student;
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
        return route('tenant.students.edit', [
            'branchOffice' => $this->branchOffice,
            'student' => $this->student
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.students.update',[
            'branchOffice' => $this->branchOffice,
            'student' => $this->student
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.students.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'student' => $this->student
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.students.trash.restore', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->student->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.students.destroy', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->student->id
        ]);
    }
}
