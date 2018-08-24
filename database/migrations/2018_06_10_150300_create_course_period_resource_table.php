<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePeriodResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_period_resource', function (Blueprint $table) {
            $table->unsignedInteger('course_period_id');
            $table->unsignedInteger('resource_id');

            $table->foreign('course_period_id')->references('id')->on('course_period');
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
        Schema::dropIfExists('course_period_resource');
    }
}
