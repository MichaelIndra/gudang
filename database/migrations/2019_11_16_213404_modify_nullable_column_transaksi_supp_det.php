<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyNullableColumnTransaksiSuppDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_supp_dets', function (Blueprint $table) {
            $table->string('id_trans_supp', 20)->nullable()->change();
            $table->string('id_brg', 15)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_supp_dets', function (Blueprint $table) {
            $dropColumn(['id_trans_supp','id_brg']);
        });
    }
}
