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
            $table->unsignedInteger('branch_office_id');
            $table->unsignedInteger('promotion_id');
            $table->string('name', 70);
            $table->string('last_name', 70);
            $table->string('id_card', 13);
            $table->string('phone', 17);
            $table->string('address');
            $table->string('tutor_id_card', 13)->nullable();
            $table->unique(['branch_office_id', 'promotion_id']);
            $table->unique(['branch_office_id', 'id_card', 'phone']);
            $table->timestamp('birthdate');
            $table->timestamp('signed_up')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('promotion_id')->references('id')->on('promotions');
            $table->foreign('branch_office_id')->references('id')->on('branch_offices');
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
