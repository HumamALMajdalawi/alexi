<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeLabelColumnIntoJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        /*
        Schema::table('jobs', function (Blueprint $table) {
            //
            $table->enum('label', ['Allocated', 'Confirmed by fitter', 'Confirmed by contracts manager', 'JOB done'])->change();
        });
        */

    

DB::statement("ALTER TABLE jobs CHANGE COLUMN label label ENUM('Allocated', 'Confirmed_by_fitter', 'Confirmed_by_contracts_manager','JOB_done') NOT NULL DEFAULT 'Allocated'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
