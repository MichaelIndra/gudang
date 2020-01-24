<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiCustGlbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_cust_glbs', function (Blueprint $table) {
            $table->string('id_trans_cust', 20);
            $table->integer('total_harga');
            $table->integer('diskon');
            $table->string('keterangan', 40)->nullable();
            $table->string('status', 10);
            $table->string('id_sales', 15);
            $table->string('id_cust', 15);
            $table->string('id_user', 15)->nullable();//sementara
            $table->timestamps();

            $table->primary('id_trans_cust');
            $table->foreign('id_sales')
                ->references('id_sales')->on('sales');

            $table->foreign('id_cust')
                ->references('id_cust')->on('customers');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_cust_glbs');
    }
}
