<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('promotion_id');
            $table->string('identification', 20);
            $table->string('name', 70);
            $table->string('last_name', 70);
            $table->string('tel_number', 10);
            $table->string('enrollment');
            $table->string('address');
            $table->tinyInteger('is_adult')->default(false);
            $table->string('requirements');
            $table->timestamps();

            $table->foreign('promotion_id')->references('id')->on('promotions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
