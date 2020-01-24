<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKeteranganInHargacusthistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('harga_cust_hists', function (Blueprint $table) {
            $table->string('keterangan', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('harga_cust_hists', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
}
