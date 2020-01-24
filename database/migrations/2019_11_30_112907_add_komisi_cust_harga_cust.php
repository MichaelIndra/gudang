<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKomisiCustHargaCust extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('harga_custs', function (Blueprint $table) {
            $table->integer('komisi')->nullable();
            $table->string('id_cust', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('harga_custs', function (Blueprint $table) {
            $table->drop('komisi')->nullable();
            $table->drop('id_cust')->nullable();
        });
    }
}
