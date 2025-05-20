<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeaderUserController extends Controller
{
    public function editProfile(){
        return view('user.editProfile');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $isLoginChanged = $user->login !== $request->input('login');

        $validator = Validator::make($request->all(), [
            'login' => [
                'required',
                'string',
                'max:255',
                $isLoginChanged ? 'unique:users,login' : 'nullable',
            ],
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'full_phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ],[
            'login.required' => 'Обовʼязкове поле.',
            'login.unique' => 'Користувач з таким логіном вже існує.',
            'login.max' => 'Логін не повинен перевищувати 255 символів.',

            'surname.required' => 'Обовʼязкове поле.',
            'surname.string' => 'Прізвище повинно бути рядком.',
            'surname.max' => 'Прізвище не повинно перевищувати 255 символів.',

            'name.required' => 'Обовʼязкове поле.',
            'name.string' => 'Імʼя повинно бути рядком.',
            'name.max' => 'Імʼя не повинно перевищувати 255 символів.',

            'email.required' => 'Обовʼязкове поле.',
            'email.email' => 'Недійсна електронна пошта.',
            'email.unique' => 'Користувач з такою електронною поштою вже існує.',

            'full_phone.required' => 'Обовʼязкове поле.',
            'full_phone.string' => 'Телефон повинен бути рядком.',
            'full_phone.max' => 'Телефон не повинен перевищувати 255 символів.',

            'address.required' => 'Обовʼязкове поле.',
            'address.string' => 'Адреса повинна бути рядком.',
            'address.max' => 'Адреса не повинна перевищувати 255 символів.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'login' => $request->login ?? $user->login,
            'surname' => $request->surname,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->full_phone,
            'address' =>$request->address,
        ]);

        return redirect()->route('user.editProfile')->with('success', 'Данні користувача оновлено успішно');
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
