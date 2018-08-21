<?php

namespace App\Presenters\TypeCourse;

use App\{BranchOffice, TypeCourse};

class UrlPresenter
{
    /**
     * @var \App\BranchOffice
     */
    private $branchOffice;

    /**
     * @var \App\TypeCourse
     */
    private $typeCourse;

    /**
     * UrlPresenter constructor.
     *
     * @param \App\BranchOffice $branchOffice
     * @param \App\TypeCourse $typeCourse
     */
    public function __construct(BranchOffice $branchOffice, TypeCourse $typeCourse)
    {
        $this->branchOffice = $branchOffice;
        $this->typeCourse = $typeCourse;
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
        return route('tenant.typeCourses.edit', [
            'branchOffice' => $this->branchOffice,
            'typeCourse' => $this->typeCourse
        ]);
    }

    /**
     * @return string
     */
    public function update()
    {
        return route('tenant.typeCourses.update',[
            'branchOffice' => $this->branchOffice,
            'typeCourse' => $this->typeCourse
        ]);
    }

    /**
     * @return string
     */
    public function trash()
    {
        return route('tenant.typeCourses.trash.destroy', [
            'branchOffice' => $this->branchOffice,
            'typeCourse' => $this->typeCourse
        ]);
    }

    /**
     * @return string
     */
    public function restore()
    {
        return route('tenant.typeCourses.trash.restore', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->typeCourse->id
        ]);
    }

    /**
     * @return string
     */
    public function delete()
    {
        return route('tenant.typeCourses.destroy', [
            'branchOffice' => $this->branchOffice,
            'id' => $this->typeCourse->id
        ]);
    }
}
