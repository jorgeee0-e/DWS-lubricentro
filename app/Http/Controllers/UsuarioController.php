<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }
    public function deactivateUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->status = 0; // Desactivarlo
        $user->save();

        return response()->json(['message' => 'Usuario desactivado exitosamente']);
    }
    public function updateUser(Request $request, $id)
    {
        // Validar los campos recibidos en la solicitud
        $request->validate([
            'role' => 'required|in:superusuario,administrador_inventarios,vendedor',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Buscar al usuario
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Actualizar el rol solo si ha cambiado
    if ($user->role !== $request->role) {
        $user->role = $request->role;
    }

    // Actualizar el nombre solo si ha cambiado
    if ($user->name !== $request->name) {
        $user->name = $request->name;
    }

    // Actualizar el correo solo si ha cambiado
    if ($user->email !== $request->email) {
        $user->email = $request->email;
    }

    $user->save();

        return response()->json(['message' => 'Usuario actualizado exitosamente', 'user' => $user]);
    }
}
