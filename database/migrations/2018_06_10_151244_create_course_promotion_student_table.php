<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePromotionStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_promotion_student', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_promotion_id');
            $table->unsignedInteger('student_id');
            $table->timestamps();

            $table->foreign('course_promotion_id')->references('id')->on('course_promotion');
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
        Schema::dropIfExists('course_promotion_student');
    }
}
