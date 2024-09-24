<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        // Повертаємо відфільтровані продукти з необхідними полями
        return $this->products->map(function($product) {
            return [
                'article' => $product->article,
                'name' => $product->name,
                'category' => $product->category->name,  // Виведення назви категорії
                'description' => $product->description,
                'size' => $product->size,
                'quantity' => $product->quantity,
                'price' => $product->price,
                'discount' => $product->discount ? $product->discount->percentage . '%' : 'Немає',
                'is_active' => $product->is_active ? 'Активний' : 'Неактивний'
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Артикул',
            'Назва',
            'Категорія',
            'Опис',
            'Розмір',
            'Кількість',
            'Ціна',
            'Знижка',
            'Статус'
        ];
    }
}
