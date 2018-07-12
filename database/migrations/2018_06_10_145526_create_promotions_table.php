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
            $table->unsignedInteger('branch_office_id');
            $table->integer('promotion_no');
            $table->enum('status', [Promotion::STATUS_CURRENT, Promotion::STATUS_FINISHED])->default(Promotion::STATUS_CURRENT);
            $table->unique(['branch_office_id', 'promotion_no']);
            $table->timestamps();

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
        Schema::dropIfExists('promotions');
    }
}
