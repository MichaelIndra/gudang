<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiCustByrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_cust_byrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bayar');
            $table->string('status', 10);
            $table->string('metode', 10);
            $table->string('bukti_bayar',20)->nullable();
            $table->string('id_cust',15);
            $table->string('id_trans_cust',20);
            $table->timestamps();

            $table->foreign('id_trans_cust')
                ->references('id_trans_cust')->on('transaksi_cust_glbs')
                ->onDelete('cascade');
            $table->foreign('id_cust')
                ->references('id_cust')->on('customers')
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
        Schema::dropIfExists('transaksi_cust_byrs');
    }
}
