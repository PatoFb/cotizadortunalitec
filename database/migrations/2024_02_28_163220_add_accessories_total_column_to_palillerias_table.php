<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessoriesTotalColumnToPalilleriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('palillerias', function (Blueprint $table) {
            $table->float('accessories_total');
            $table->float('systems_total');
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
            $table->dropColumn('accessories_total');
            $table->dropColumn('systems_total');
        });
    }
}
