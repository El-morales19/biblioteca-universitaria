<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                if (auth()->user()->role !== 'admin') {
                    abort(403);
                }
                return $next($request);
            }
        ];
    }
    public function index()
    {
        $users = User::where('active', true)->orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = ['admin', 'bibliotecario', 'alumno'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', Password::defaults()],
            'role' => 'required|in:admin,bibliotecario,alumno',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'bibliotecario', 'alumno'];
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', Password::defaults()],
            'role' => 'required|in:admin,bibliotecario,alumno',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'No puedes dar de baja a tu propio usuario activo.']);
        }

        $user->update([
            'active' => false
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario dado de baja exitosamente.');
    }

    public function inactive()
    {
        $users = User::where('active', false)->orderBy('name')->get();
        return view('users.inactive', compact('users'));
    }

    public function restore(User $user)
    {
        $user->update([
            'active' => true
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario reactivado exitosamente.');
    }
}
