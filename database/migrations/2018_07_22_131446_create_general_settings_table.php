<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon_name', 100)->nullable();
            $table->string('app_name', 100)->nullable();
            $table->string('skin', 50)->nullable();
            $table->string('owner', 200)->nullable();
            $table->string('version', 10)->nullable();
            $table->integer('per_page')->nullable();
            $table->integer('per_page_api')->nullable();
            $table->string('datetime_format', 20)->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
