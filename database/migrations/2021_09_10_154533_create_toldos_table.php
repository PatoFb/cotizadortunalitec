<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toldos', function (Blueprint $table) {
            $table->id();
            $table->float('width');
            $table->float('projection');
            $table->integer('quantity');
            $table->bigInteger('order_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('control_id')->unsigned()->index()->nullable(true);
            $table->integer('control_quantity');
            $table->bigInteger('cover_id')->unsigned()->index()->nullable(true);
            $table->integer('mechanism_id')->unsigned()->index()->nullable(true);
            $table->integer('model_id')->unsigned()->index()->nullable(true);
            $table->float('price')->nullable()->default(0);
            $table->integer('canopy')->nullable(true);
            $table->bigInteger('sensor_id')->unsigned()->index()->nullable(true);
            $table->integer('bambalina');
            $table->bigInteger('voice_id')->unsigned()->index()->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toldos');
    }
}
