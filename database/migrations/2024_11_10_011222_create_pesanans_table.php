<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('pesanan_name'); // Nama produk pesanan
            $table->integer('price'); // Harga produk pesanan
            $table->integer('quantity'); // Jumlah produk pesanan
            $table->string('pesanan_color')->nullable(); // Warna produk (opsional)
            $table->string('pesanan_image'); // Gambar produk pesanan
            $table->timestamps(); // Waktu pembuatan dan update pesanan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
}
