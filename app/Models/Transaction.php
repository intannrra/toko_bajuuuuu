<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_id', 'shipping_method', 'payment_method', 'total_amount'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}

