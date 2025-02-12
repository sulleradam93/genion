<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['manager', 'admin'])
            ->select('id', 'name', 'email', 'phone', 'role')
            ->get();

        return view('managers.index', compact('users'));
    }

    public function create()
    {
        return view('managers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'role' => 'required|in:manager,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => bcrypt('defaultpassword')
        ]);

        return redirect()->route('managers.index')->with('success', 'Manager sikeresen hozzáadva.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (!in_array($user->role, ['manager', 'admin'])) {
            return redirect()->route('managers.index');
        }

        return view('managers.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'phone' => 'nullable|string',
            'role' => 'required|in:admin',
        ], [
            'name.required' => 'A név mező kitöltése kötelező.',
            'name.max' => 'A név nem lehet hosszabb, mint 255 karakter.',
            'email.required' => 'Az email mező kitöltése kötelező.',
            'email.email' => 'Az email cím nem megfelelő.',
            'email.unique' => 'Ez az email cím már regisztrálva van.',
            'role.required' => 'A szerep mező kitöltése kötelező.',
            'role.in' => 'A lefokozás nem lehetséges. Csak admin szerep választható.',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('managers.index')->with('success', 'Manager sikeresen frissítve.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->route('managers.index')->with('error', 'Admin felhasználót nem lehet törölni.');;
        }

        $user->delete();

        return redirect()->route('managers.index')->with('success', 'Manager sikeresen törölve.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        if (!in_array($user->role, ['manager', 'admin'])) {
            return redirect()->route('managers.index');
        }

        return view('managers.show', compact('user'));
    }
}
