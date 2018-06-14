<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Student
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CoursePromotion[] $course_promotion
 * @property-read \App\Payment $payment
 * @property-read \App\Promotion $promotion
 */
	class Student extends \Eloquent {}
}

namespace App{
/**
 * App\Payment
 *
 * @property-read \App\Student $student
 */
	class Payment extends \Eloquent {}
}

namespace App{
/**
 * App\Course
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Promotion[] $promotions
 */
	class Course extends \Eloquent {}
}

namespace App{
/**
 * App\Promotion
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $courses
 * @property-read \App\institute $institute
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 */
	class Promotion extends \Eloquent {}
}

namespace App{
/**
 * App\Classroom
 *
 */
	class Classroom extends \Eloquent {}
}

namespace App{
/**
 * App\Resource
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CoursePromotion[] $course_promotion
 */
	class Resource extends \Eloquent {}
}

namespace App{
/**
 * App\CoursePromotion
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Resource[] $resource
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 * @property-read \App\Teacher $teacher
 */
	class CoursePromotion extends \Eloquent {}
}

namespace App{
/**
 * App\institute
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Promotion[] $promotions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 */
	class institute extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\institute[] $institutes
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Teacher
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CoursePromotion[] $course_promotion
 */
	class Teacher extends \Eloquent {}
}

