<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cfdi')->nullable(true);
            $table->string('rfc')->nullable(true);
            $table->string('razon_social')->nullable(true);
            $table->string('phone')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cfdi');
            $table->dropColumn('rfc');
            $table->dropColumn('razon_social');
            $table->dropColumn('phone');
        });
    }
}