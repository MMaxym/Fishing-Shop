<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
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
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $imagePath = $request->file('image')->store('product_images', 'public');

        ProductImage::create([
            'product_id' => $product->id,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.products.index', $product)->with('success', 'Зображення додано успішно!!!');
    }

    public function edit(Product $product)
    {
        $images = $product->images;
        return view('admin.products.images.edit', compact('product', 'images'));
    }

    public function destroy(Product $product, ProductImage $image)
    {
        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }
        $image->delete();

        return redirect()->route('admin.products.images.edit', ['product' => $product->id])->with('error', 'Зображення видалено успішно!!!');
    }

}
