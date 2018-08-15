<?php

use App\Period;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('promotion_id');
            $table->enum('period_no', [Period::PERIOD_NO_1, Period::PERIOD_NO_2, Period::PERIOD_NO_3]);
            $table->enum('status', [Period::STATUS_WITHOUT_STARTING, Period::STATUS_CURRENT, Period::STATUS_FINISHED])->default(Period::STATUS_WITHOUT_STARTING);
            $table->unique(['promotion_id', 'period_no']);
            $table->timestamp('start_date_at')->nullable();
            $table->timestamp('ends_at')->nullable();
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
        Schema::dropIfExists('periods');
    }
}
