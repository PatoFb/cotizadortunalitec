<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessoriesTotalColumnToToldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toldos', function (Blueprint $table) {
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
        Schema::table('toldos', function (Blueprint $table) {
            $table->dropColumn('accessories_total');
            $table->dropColumn('systems_total');
        });
    }
}
