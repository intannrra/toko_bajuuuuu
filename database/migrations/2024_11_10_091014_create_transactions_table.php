<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('address'); // Alamat pengiriman
            $table->string('shipping_service'); // Jasa pengiriman
            $table->string('payment_method'); // Metode pembayaran
            $table->string('payment_proof')->nullable(); // Bukti pembayaran
            $table->string('status')->default('pending'); // Status transaksi
            $table->decimal('total_price', 15, 2)->default(0)->change(); // Total harga
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
        Schema::dropIfExists('transactions');
    }
}
