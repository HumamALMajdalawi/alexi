<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->text("client_order_number")->nullable();
            $table->string('developer')->nullable();
            $table->string('site')->nullable();
            $table->integer('plot')->default(0);
            $table->string('house_type')->nullable();
            $table->text('rooms')->nullable();
            $table->string('net_m2')->nullable();
            $table->integer('carpet')->default(0);
            $table->integer('underlay')->default(0);
            $table->integer('matwell')->default(0);
            $table->integer('lvt')->default(0);
            $table->integer('title_size')->default(0);
            $table->integer('stripping')->default(0);
            $table->integer('angle')->default(0);
            $table->text('vinyl')->nullable();
            $table->integer('wood')->default(0);
            $table->string('value')->nullable();
            $table->string('on_order')->nullable();
            $table->string('screed_date')->nullable();
            $table->string('screeded_by')->nullable();
            $table->string('fitted_date')->nullable();
            $table->string('fitter')->nullable();
            $table->string('invoice')->nullable();
            $table->enum('sign_off', ['YES', 'NO'])->default('NO');
            $table->string('self_billing_date_signed')->nullable();
            $table->string('prep')->nullable();
            $table->string('prep_inv_date')->nullable();
            $table->string('fit')->nullable();
            $table->string('fit_inv_date')->nullable();
            $table->string('protection')->nullable();
            $table->string('protect_inv_date')->nullable();
            $table->string('misc')->nullable();
            $table->string('misc_inv_details')->nullable();
            $table->string('misc_inv_date')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
