<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurtainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curtains', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->bigInteger('order_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('model_id')->unsigned()->index()->nullable(true);
            $table->float('price')->nullable()->default(0);
            $table->float('width');
            $table->float('height');
            $table->bigInteger('cover_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('handle_id')->unsigned()->index()->nullable(true);
            $table->bigInteger('control_id')->unsigned()->index()->nullable(true);
            $table->integer('canopy')->nullable(true);
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
        Schema::dropIfExists('curtains');
    }
}
