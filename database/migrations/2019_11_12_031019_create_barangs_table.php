<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->string('id_brg', 15);
            $table->string('nama_brg', 20);
            $table->string('keterangan', 20);
            $table->integer('komisi');
            $table->string('id_supp', 15);
            $table->timestamps();

            $table->primary('id_brg');
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
        Schema::dropIfExists('barangs');
    }
}
