<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'discount_id',
        'article',
        'name',
        'description',
        'size',
        'other',
        'quantity',
        'price',
        'is_active',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'discount_id' => 'integer',
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


}
