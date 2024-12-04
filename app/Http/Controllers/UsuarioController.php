<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //
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
}
