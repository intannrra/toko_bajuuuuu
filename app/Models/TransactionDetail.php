<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Relasi ke model Transaction
     */
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class)->withPivot('quantity', 'price');
    }

        /**
         * Relasi ke model Product
         */
        public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }

}
