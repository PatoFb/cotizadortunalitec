<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoiceColumnsToPalilleriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('palillerias', function (Blueprint $table) {
            $table->integer('voice_id')->index()->nullable(true)->unsigned();
            $table->integer('voice_quantity')->nullable(true);
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
            $table->dropColumn('voice_id');
            $table->dropColumn('voice_quantity');
        });
    }
}
