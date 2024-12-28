<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->string('address'); // Alamat pengiriman
            $table->decimal('total_price', 15, 2); // Total harga
            $table->string('payment_method'); // Metode pembayaran
            $table->string('status'); // Status transaksi
            $table->string('shipping_option'); // Jasa pengiriman
            $table->text('message')->nullable(); // Pesan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
