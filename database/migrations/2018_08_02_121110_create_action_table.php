<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string("icon")->nullable();
            $table->string("title")->nullable();
            $table->string("group_name")->nullable();
            $table->boolean("is_active")->default(1);
            $table->boolean("is_menu")->default(0);
            $table->boolean("is_home")->nullable();
            $table->string("link")->nullable();
            $table->integer("menu_order")->nullable();
            $table->integer("parent_id")->nullable();
            $table->integer("menu_parent_id")->nullable();
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
        Schema::dropIfExists('actions');
    }
}
