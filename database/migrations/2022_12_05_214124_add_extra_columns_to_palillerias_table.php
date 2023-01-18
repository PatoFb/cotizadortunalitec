<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToPalilleriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('palillerias', function (Blueprint $table) {
            $table->integer('trave')->nullable(true);
            $table->integer('semigoal')->nullable(true);
            $table->integer('goal')->nullable(true);
            $table->integer('trave_quantity')->nullable(true);
            $table->integer('semigoal_quantity')->nullable(true);
            $table->integer('goal_quantity')->nullable(true);
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
            $table->dropColumn('trave');
            $table->dropColumn('semigoal');
            $table->dropColumn('goal');
            $table->dropColumn('trave_quantity');
            $table->dropColumn('semigoal_quantity');
            $table->dropColumn('goal_quantity');
        });
    }
}
