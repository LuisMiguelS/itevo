<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePeriodStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_period_student', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_period_id');
            $table->unsignedInteger('student_id');
            $table->unique(['course_period_id', 'student_id']);
            $table->timestamps();

            $table->foreign('course_period_id')->references('id')->on('course_period');
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_period_student');
    }
}
