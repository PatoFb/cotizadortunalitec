<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemScreenyCurtainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_screeny_curtains', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id')->unsigned()->index()->nullable(true);
            $table->float('width');
            $table->float('height');
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
        Schema::dropIfExists('system_screeny_curtains');
    }
}
