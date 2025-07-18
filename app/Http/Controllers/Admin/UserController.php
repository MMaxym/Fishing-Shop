<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('user.main')->with('error', 'Будь ласка, увійдіть в акаунт, щоб перейти на сторінку адміністратора.');
        }

        $users = User::with('role')->get();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users|max:255',
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'login' => $request->input('login'),
            'surname' => $request->input('surname'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'role_id' => $request->input('role_id'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Користувач створений успішно!!!');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
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
            //'password' => 'required|string|min:8',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'login' => $validated['login'] ?? $user->login,
            'surname' => $validated['surname'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            //'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Данні користувача оновлено успішно!!!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('error', 'Користувача успішно видалено!!!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('login', 'like', "%{$query}%")->with('role')->get();

        return response()->json(['users' => $users]);
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');
        $role = $request->input('role');

        $users = User::with('role')
            ->when($query, function($queryBuilder) use ($query) {
                $queryBuilder->where('login', 'like', "%{$query}%");
            })
            ->when($role, function($queryBuilder) use ($role) {
                $queryBuilder->where('role_id', $role);
            })
            ->get();

        return response()->json(['users' => $users]);
    }

    public function excelExport(Request $request)
    {
        $filteredUser = User::query();

        if ($request->filled('query')) {
            $filteredUser->where('name', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->filled('role')) {
            $filteredUser->where('role_id', $request->input('role'));
        }

        $users = $filteredUser->get(['login', 'surname', 'name', 'email', 'phone', 'address', 'role_id',]);

        return Excel::download(new UsersExport($users), 'users_export_' . now()->addHours(3)->format('Y-m-d_H:i:s') . '.xlsx');
    }

    public function pdfExport(Request $request)
    {
        $filteredUser = User::query();

        if ($request->filled('query')) {
            $filteredUser->where('name', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->filled('role')) {
            $filteredUser->where('role_id', $request->input('role'));
        }

        $users = $filteredUser->get(['login', 'surname', 'name', 'email', 'phone', 'address', 'role_id']);

        $pdf = PDF::loadView('admin.users.export.pdf.invoice', compact('users'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('users_report_' . now()->addHours(3)->format('Y-m-d_H:i:s') . '.pdf');
    }
}
