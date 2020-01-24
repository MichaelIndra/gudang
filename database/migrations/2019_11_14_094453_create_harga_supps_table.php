<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaSuppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_supps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_brg', 15);
            $table->integer('harga');
            $table->timestamps();

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
        Schema::dropIfExists('harga_supps');
    }
}
