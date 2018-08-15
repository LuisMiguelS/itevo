<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_promotion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('promotion_id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('classroom_id');
            $table->decimal('price', 8, 2);
            $table->unique(['promotion_id', 'classroom_id', 'start_time']);
            $table->unique(['promotion_id', 'classroom_id', 'output_time']);
            $table->dateTime('start_time');
            $table->dateTime('output_time');
            $table->dateTime('start_date_at');
            $table->dateTime('ends_at');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('promotion_id')->references('id')->on('promotions');
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
        Schema::dropIfExists('course_promotion');
    }
}
