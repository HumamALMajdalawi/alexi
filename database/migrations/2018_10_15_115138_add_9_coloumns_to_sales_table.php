<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add9ColoumnsToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            //
             $table->text('dpm')->nullable();
               $table->text('vinyl_tiles')->nullable();
                 $table->text('screed')->nullable();
                   $table->text('domestic_vinyl')->nullable();
                     $table->text('safety_flooring')->nullable();
                       $table->text('cap_and_cove')->nullable();
                         $table->text('laminate')->nullable();
                           $table->text('communal_carpet')->nullable();
                             $table->text('nosings')->nullable();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
}
