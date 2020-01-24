<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiCustDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_cust_dets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('harga_total');
            $table->integer('komisi');
            $table->string('id_trans_cust', 20);
            $table->string('id_brg', 15);
            $table->timestamps();

            $table->foreign('id_trans_cust')
                ->references('id_trans_cust')->on('transaksi_cust_glbs')
                ->onDelete('cascade');
            $table->foreign('id_brg')
                ->references('id_brg')->on('barangs')
                ->onDelete('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_cust_dets');
    }
}
