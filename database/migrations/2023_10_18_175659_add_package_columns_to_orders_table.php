<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPackageColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('small_packages');
            $table->integer('large_packages');
            $table->float('total_packages');
            $table->float('insurance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('small_packages');
            $table->dropColumn('large_packages');
            $table->dropColumn('total_packages');
            $table->dropColumn('insurance');
        });
    }
}
