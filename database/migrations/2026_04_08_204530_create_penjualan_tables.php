<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Bikin tabel penjualan (Struk Utama)
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('total');
        });

        // 2. Bikin tabel penjualan_detail (Rincian Barang)
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id('id_penj_detail');
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_barang'); // Asumsi nyambung ke ID barang kamu
            $table->integer('harga');
            $table->integer('qty');
            $table->integer('subtotal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualan_detail');
        Schema::dropIfExists('penjualan');
    }
};