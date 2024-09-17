<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'shipping_method_id',
        'discount_id',
        'address',
        'total_amount',
        'status',
        'created',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'payment_method_id' => 'integer',
        'shipping_method_id' => 'integer',
        'discount_id' => 'integer',
        'created' => 'timestamp',
        'total_amount' => 'decimal:2',
    ];

    protected $dates = [
        'created',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Payment_method::class, 'payment_method_id');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(Shipping_method::class, 'shipping_method_id');
    }
}
