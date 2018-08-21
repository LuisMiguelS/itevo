<?php

namespace App\Presenters\Course;

use App\{BranchOffice, Course};

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

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\Course $course
     */
    public function __construct(BranchOffice $branchOffice, Course $course)
    {
        $this->branchOffice = $branchOffice;
        $this->course = $course;
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
        return route('tenant.courses.edit', [
            'branchOffice' => $this->branchOffice,
            'course' => $this->course
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.courses.update',[
            'branchOffice' => $this->branchOffice,
            'course' => $this->course
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.courses.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'course' => $this->course
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.courses.trash.restore', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->course->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.courses.destroy', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->course->id
        ]);
    }
}
