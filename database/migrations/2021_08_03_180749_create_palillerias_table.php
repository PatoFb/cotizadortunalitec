<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePalilleriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('palillerias', function (Blueprint $table) {
            $table->id();
            $table->float('width');
            $table->float('height');
            $table->integer('quantity');
            $table->bigInteger('order_id')->unsigned()->index()->nullable(true);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('model_id')->unsigned()->index()->nullable(true);
            $table->integer('guide')->nullable(true);
            $table->integer('guide_quantity');
            $table->bigInteger('control_id')->unsigned()->index()->nullable(true);
            $table->integer('control_quantity');
            $table->bigInteger('cover_id')->unsigned()->index()->nullable(true);
            $table->integer('mechanism_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('handle_id')->unsigned()->index()->nullable(true);
            $table->float('price')->nullable()->default(0);
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
        Schema::dropIfExists('palillerias');
    }
}
