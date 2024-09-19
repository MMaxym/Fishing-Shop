<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function create(Product $product)
    {
        return view('admin.products.images.create', compact('product'));
    }


    public function store(Request $request, Product $product)
    {
        $request->validate([
            'images' => 'required|images|max:2048',
        ]);

        $imagePath = $request->file('images')->store('product_images', 'public');

        ProductImage::create([
            'product_id' => $product->id,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.products.images.edit', $product)->with('success', 'Image added successfully.');
    }

    public function edit(Product $product)
    {
        $images = $product->images;
        return view('admin.products.images.edit', compact('product', 'images'));
    }


    public function update(Request $request, Product $product, ProductImage $image)
    {
        // Implement update logic here
    }

    public function destroy(Product $product, ProductImage $image)
    {
        // Видаляємо зображення з файлової системи
        if (Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        $image->delete();

        return redirect()->route('admin.products.images.edit', $product)->with('success', 'Image deleted successfully.');
    }
}
