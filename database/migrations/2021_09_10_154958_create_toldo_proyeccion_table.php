<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToldoProyeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toldo_proyeccion', function (Blueprint $table) {
            $table->id();
            $table->integer('sistema_toldo_id')->index()->unsigned()->nullable(true);
            $table->float('projection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toldo_proyeccion');
    }
}
