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
            $table->integer('period');
            $table->enum('status', [Promotion::STATUS_CURRENT, Promotion::STATUS_FINISHED, Promotion::STATUS_INSCRIPTION])->default(Promotion::STATUS_INSCRIPTION);
            $table->unique(['branch_office_id', 'period', 'created_at']);
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
