<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
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
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function products()
    {
        return $this->hasMany(ProductsInOrder::class, 'order_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            do {
                $order->id = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (self::where('id', $order->id)->exists());
        });
    }
}
