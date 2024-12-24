<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',        // ID pengguna, null jika pengguna tidak login
        'product_id',     // ID produk yang dimasukkan ke keranjang
        'quantity',       // Jumlah produk
        'price',
    ];

    /**
     * Relasi ke model Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke model User (opsional jika keranjang terkait pengguna).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
