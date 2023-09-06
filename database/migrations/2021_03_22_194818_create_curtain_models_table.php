<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurtainModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curtain_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('max_resistance');
            $table->string('production_time');
            $table->float('max_width');
            $table->float('max_height');
            $table->string('photo')->nullable(true);
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
        Schema::dropIfExists('curtain_models');
    }
}
