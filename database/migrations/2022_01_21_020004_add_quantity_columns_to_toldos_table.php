<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityColumnsToToldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toldos', function (Blueprint $table) {
            $table->integer('sensor_quantity')->nullable(true);
            $table->integer('voice_quantity')->nullable(true);
            $table->integer('handle_quantity')->nullable(true);
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
            $table->dropColumn('sensor_quantity');
            $table->dropColumn('voice_quantity');
            $table->dropColumn('handle_quantity');
        });
    }
}
