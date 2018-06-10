<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePromotionResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_promotion_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_promotion_id');
            $table->unsignedInteger('resource_id');
            $table->timestamps();

            $table->foreign('course_promotion_id')->references('id')->on('course_promotion');
            $table->foreign('resource_id')->references('id')->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_promotion_resource');
    }
}
