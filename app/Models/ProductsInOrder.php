<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsInOrder extends Model
{
    use HasFactory;

    protected $table = 'products_in_order';

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'price',
        'size',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'order_id' => 'integer',
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
