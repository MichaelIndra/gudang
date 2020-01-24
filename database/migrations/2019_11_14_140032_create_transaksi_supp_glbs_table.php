<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiSuppGlbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_supp_glbs', function (Blueprint $table) {
            $table->string('id_trans_supp', 20);
            $table->integer('total_harga');
            $table->integer('diskon');
            $table->string('keterangan', 40)->nullable();
            $table->string('nota_supp', 50)->nullable();
            $table->string('id_supp', 15);
            $table->timestamps();

            $table->primary('id_trans_supp');
            $table->foreign('id_supp')
                ->references('id_supp')->on('suppliers')
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
        Schema::dropIfExists('transaksi_supp_glbs');
    }
}
