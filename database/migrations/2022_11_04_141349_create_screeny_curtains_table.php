<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreenyCurtainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screeny_curtains', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->bigInteger('order_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('model_id')->unsigned()->index()->nullable(true);
            $table->integer('mechanism_id')->unsigned()->index()->nullable(true);
            $table->float('price')->nullable()->default(0);
            $table->float('width');
            $table->float('height');
            $table->bigInteger('cover_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('handle_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('control_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('canopy_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('voice_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('sensor_id')->unsigned()->index()->nullable(true);
            $table->integer('sensor_quantity')->nullable(true);
            $table->integer('voice_quantity')->nullable(true);
            $table->integer('handle_quantity')->nullable(true);
            $table->integer('control_quantity')->nullable(true);
            $table->string('installation_type')->nullable(true);
            $table->string('mechanism_side')->nullable(true);
            $table->string('view_type')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('screeny_curtains');
    }
}
