<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komisis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_sales', 15);
            $table->string('id_trans_cust', 20);
            $table->string('id_brg', 15);
            $table->integer('komisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komisis');
    }
}
