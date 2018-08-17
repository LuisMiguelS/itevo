<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_period', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('period_id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('classroom_id');
            $table->decimal('price', 8, 2);
            $table->dateTime('start_at');
            $table->dateTime('ends_at');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('period_id')->references('id')->on('periods');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('classroom_id')->references('id')->on('classrooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_period');
    }
}
