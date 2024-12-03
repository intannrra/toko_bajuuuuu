<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',             // Alamat pengiriman
        'shipping_service',    // Jasa pengiriman
        'payment_method',      // Metode pembayaran
        'payment_proof',       // Bukti pembayaran (path file)
        'status',              // Status transaksi (misalnya pending, completed, canceled)
        'total_price',
    ];
}

