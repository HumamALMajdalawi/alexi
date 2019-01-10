<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFitterRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fitter_rates', function (Blueprint $table) {
            $table->increments('id');
               $table->unsignedInteger('fitter_id');
            $table->foreign('fitter_id')->references('id')->on('fitters');
            $table->string('type')->nullable();
            $table->text('prices')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fitter_rates');
    }
}
