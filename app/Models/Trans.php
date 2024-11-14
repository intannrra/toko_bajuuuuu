<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'shipping_service',
        'payment_method',
        'payment_proof'
    ];
}
