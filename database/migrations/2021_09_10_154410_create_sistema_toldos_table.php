<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSistemaToldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema_toldos', function (Blueprint $table) {
            $table->id();
            $table->integer('modelo_toldo_id')->unsigned()->index()->nullable(true);
            $table->float('width');
            $table->float('projection');
            $table->integer('mechanism_id')->unsigned()->index()->nullable(true);
            $table->float('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sistema_toldos');
    }
}
