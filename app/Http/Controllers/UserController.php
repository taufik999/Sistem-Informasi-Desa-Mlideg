<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (session('role') !== 'Super Admin') return redirect('/dashboard');
        
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (session('role') !== 'Super Admin') return redirect('/dashboard');
        
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        if (session('role') !== 'Super Admin') return redirect('/dashboard');

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/admin/users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (session('role') !== 'Super Admin') return redirect('/dashboard');
        
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (session('role') !== 'Super Admin') return redirect('/dashboard');

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/admin/users')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (session('role') !== 'Super Admin') return redirect('/dashboard');

        $user = User::findOrFail($id);
        
        // Prevent deleting oneself
        if ($user->id === session('user_id')) {
            return redirect('/admin/users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect('/admin/users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
