<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id',           // ID user
        'address',           // Alamat pengiriman
        'total_price',       // Total harga
        'payment_method',    // Metode pembayaran
        'status',            // Status transaksi
        'shipping_option',   // Jasa pengiriman
        'message'            // Pesan
    ];

    /**
     * Relasi ke model User
     * Setiap transaksi dimiliki oleh satu pengguna
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model TransactionDetail
     * Setiap transaksi dapat memiliki banyak detail transaksi
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Relasi ke model Product
     * Menghubungkan transaksi dengan produk melalui tabel pivot transaction_details
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_details')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
