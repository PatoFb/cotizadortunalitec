<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionDataToToldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('toldos', function (Blueprint $table) {
            $table->string('mechanism_side')->nullable(true);
            $table->string('installation_type')->nullable(true);
            $table->string('inclination')->nullable(true);
            $table->string('bambalina_type')->nullable(true);
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
            $table->dropColumn('mechanism_side');
            $table->dropColumn('installation_type');
            $table->dropColumn('inclination');
            $table->dropColumn('bambalina_type');
        });
    }
}
