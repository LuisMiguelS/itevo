<?php

namespace App\Presenters\TypeCourse;

use App\BranchOffice;
use App\TypeCourse;

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

    public function __construct(BranchOffice $branchOffice, TypeCourse $typeCourse)
    {
        $this->branchOffice = $branchOffice;
        $this->typeCourse = $typeCourse;
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
        return route('tenant.typeCourses.destroy', [
            'branchOffice' => $this->branchOffice,
            'typeCourse' => $this->typeCourse
        ]);
    }

    public function edit()
    {
        return route('tenant.typeCourses.edit', [
            'branchOffice' => $this->branchOffice,
            'typeCourse' => $this->typeCourse
        ]);
    }

    public function update()
    {
        return route('tenant.typeCourses.update',[
            'branchOffice' => $this->branchOffice,
            'typeCourse' => $this->typeCourse
        ]);
    }
}
