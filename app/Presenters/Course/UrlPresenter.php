<?php

namespace App\Presenters\Course;

use App\BranchOffice;
use App\Course;

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\Course
     */
    private $course;

    public function __construct(BranchOffice $branchOffice, Course $course)
    {
        $this->branchOffice = $branchOffice;
        $this->course = $course;
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
        return route('tenant.courses.destroy', [
            'branchOffice' => $this->branchOffice,
            'course' => $this->course
        ]);
    }

    public function edit()
    {
        return route('tenant.courses.edit', [
            'branchOffice' => $this->branchOffice,
            'course' => $this->course
        ]);
    }

    public function update()
    {
        return route('tenant.courses.update',[
            'branchOffice' => $this->branchOffice,
            'course' => $this->course
        ]);
    }
}
