<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title")->nullable();
            $table->text("description")->nullable();
            $table->string("date")->nullable();
            $table->unsignedInteger("assigned_to")->nullable();
            $table->string("due_to")->nullable();
            $table->boolean("is_private")->default(1);
            $table->boolean("status")->default(1);
            $table->enum("label", ['todo', 'done'])->nullable();
            $table->unsignedInteger("creator")->nullable();
            $table->float("price")->default(0);
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
        Schema::dropIfExists('jobs');
    }
}
