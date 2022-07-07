<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdColumnsToCurtainModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curtain_models', function (Blueprint $table) {
            $table->integer('tube_id')->unsigned()->index()->nullable(true);
            $table->integer('panel_id')->unsigned()->index()->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curtain_models', function (Blueprint $table) {
            $table->dropColumn('panel_id');
            $table->dropColumn('tube_id');
        });
    }
}
