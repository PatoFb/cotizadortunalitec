<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('project')->nullable(true)->default("NA");
            $table->string('activity')->default("Oferta");
            $table->string('comments')->nullable(true)->default("Sin comentarios");
            $table->bigInteger('user_id')->unsigned()->index()->nullable(true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->float('price')->nullable(true)->default(0);
            $table->float('discount')->nullable(true)->default(0);
            $table->float('total')->nullable(true)->default(0);
            $table->string('state');
            $table->string('city');
            $table->string('zip_code');
            $table->string('line1');
            $table->string('line2');
            $table->string('reference')->nullable(true);
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
        Schema::dropIfExists('orders');
    }
}
