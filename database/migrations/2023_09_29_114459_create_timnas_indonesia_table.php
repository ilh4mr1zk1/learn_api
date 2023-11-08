<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimnasIndonesiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timnas_indonesia', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemain');
            $table->string('daerah_asal_pemain');
            $table->string('posisi_pemain');
            $table->softDeletes();
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
        Schema::dropIfExists('timnas_indonesia');
    }
}
