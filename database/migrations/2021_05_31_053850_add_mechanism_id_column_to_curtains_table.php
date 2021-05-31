<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMechanismIdColumnToCurtainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curtains', function (Blueprint $table) {
            $table->integer('mechanism_id')->unsigned()->index()->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curtains', function (Blueprint $table) {
            $table->dropColumn('mechanism_id');
        });
    }
}
