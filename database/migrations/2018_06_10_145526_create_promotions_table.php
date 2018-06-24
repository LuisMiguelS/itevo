<?php

use App\Promotion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id');
            $table->integer('period');
            $table->enum('status', [Promotion::STATUS_CURRENT, Promotion::STATUS_FINISHED, Promotion::STATUS_INSCRIPTION])->default(Promotion::STATUS_INSCRIPTION);
            $table->unique(['institute_id', 'period', 'created_at']);
            $table->timestamps();

            $table->foreign('institute_id')->references('id')->on('institutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
