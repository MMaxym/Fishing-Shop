<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HeaderUserController extends Controller
{
    public function editProfile(){
        return view('user.editProfile');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $isLoginChanged = $user->login !== $request->input('login');

        $validated = $request->validate([
            'login' => [
                'required',
                'string',
                'max:255',
                $isLoginChanged ? 'unique:users,login' : 'nullable',
            ],
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $user->update([
            'login' => $validated['login'] ?? $user->login,
            'surname' => $validated['surname'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('user.main')->with('success', 'Данні користувача оновлено успішно !!!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $oneMonthAgo = Carbon::now()->subMonth();

        if (empty($query)) {
            return redirect()->route('user.main');
        }

        $products = Product::with('images', 'discount')
            ->where('is_active', 1)
            ->where('name', 'LIKE', '%' . $query . '%');

        $products = $products->paginate(12);

        foreach ($products as $product) {
            $product->isDiscounted = !is_null($product->discount);
            $product->isNew = $product->created_at > $oneMonthAgo || $product->updated_at > $oneMonthAgo;
            $product->actual_price = $product->discountedPrice();
        }

        $currentPage = $products->currentPage();
        $perPage = $products->perPage();
        $totalItems = $products->total();
        $itemsShown = ($currentPage - 1) * $perPage + $products->count();

        if ($products->isEmpty()) {
            return view('user.searchProduct', ['message' => 'Нажаль, нічого не знайдено.', 'query' => $query]);
        }

        return view('user.searchProduct', compact(
            'products', 'query', 'currentPage', 'perPage', 'totalItems', 'itemsShown'
        ));
    }
}
