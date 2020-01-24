<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermToTransaksiCustByrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_cust_byrs', function (Blueprint $table) {
            $table->renameColumn('bukti_bayar', 'term');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_cust_byrs', function (Blueprint $table) {
            $table->dropColumn('term');
        });
    }
}
