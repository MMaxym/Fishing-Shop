<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
    use HasFactory;

    protected $table = 'order_tracking';

    protected $fillable =[
        'order_id',
        'status',
        'updated',
    ];

    protected $casts = [
        'updated' => 'date',
        'order_id' => 'integer',
    ];

    protected $dates = [
        'updated',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
