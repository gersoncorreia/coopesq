<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserAdminController extends Controller
{
    /**
     * List all administrative users.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($users);
    }

    /**
     * Create a new administrator/editor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', Password::min(8)],
            'role' => ['required', Rule::in(['admin', 'editor'])],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json([
            'message' => 'Usuário criado com sucesso!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
            ]
        ], 201);
    }

    /**
     * Show user details.
     */
    public function show(User $user)
    {
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at,
        ]);
    }

    /**
     * Update user details and optionally password.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'editor'])],
            'password' => ['nullable', Password::min(8)],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }

    /**
     * Delete user with protection against self-deletion.
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user() && $request->user()->id === $user->id) {
            return response()->json([
                'message' => 'Você não pode excluir sua própria conta de usuário.'
            ], 422);
        }

        $user->delete();

        return response()->json(['message' => 'Usuário excluído com sucesso!']);
    }
}
