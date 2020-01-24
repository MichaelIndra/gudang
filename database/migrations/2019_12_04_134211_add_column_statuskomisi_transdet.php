<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatuskomisiTransdet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_cust_dets', function (Blueprint $table) {
            $table->string('statuskomisi', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_cust_dets', function (Blueprint $table) {
            $table->dropColumn('statuskomisi');
        });
    }
}
