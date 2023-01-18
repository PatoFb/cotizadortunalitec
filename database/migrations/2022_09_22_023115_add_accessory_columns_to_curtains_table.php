<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessoryColumnsToCurtainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curtains', function (Blueprint $table) {
            $table->bigInteger('voice_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('sensor_id')->unsigned()->index()->nullable(true);
            $table->integer('sensor_quantity')->nullable(true);
            $table->integer('voice_quantity')->nullable(true);
            $table->integer('handle_quantity')->nullable(true);
            $table->integer('control_quantity')->nullable(true);;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curtains', function (Blueprint $table) {
            $table->dropColumn('sensor_quantity');
            $table->dropColumn('voice_quantity');
            $table->dropColumn('handle_quantity');
            $table->dropColumn('control_quantity');
            $table->dropColumn('voice_id');
            $table->dropColumn('sensor_id');
        });
    }
}
