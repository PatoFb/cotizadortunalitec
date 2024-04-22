<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderDataToPalilleriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('palillerias', function (Blueprint $table) {
            $table->string('inclination');
            $table->float('goal_height')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('palillerias', function (Blueprint $table) {
            $table->dropColumn('inclination');
            $table->dropColumn('goal_height');
        });
    }
}
