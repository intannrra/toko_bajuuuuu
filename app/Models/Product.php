<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi massal
    protected $fillable = [
        'custom_id',
        'image',
        'title',
        'size',
        'price',
        'stock',
        'description',
    ];

    /**
     * Relasi ke transaksi melalui pivot table `transaction_details`.
     */
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_details')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
