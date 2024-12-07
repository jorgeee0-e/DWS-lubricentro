<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function resetPassword(Request $request)
    {
        // Validar la entrada del usuario (email, token, nueva contraseña)
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Intentar restablecer la contraseña
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Actualizar la contraseña del usuario
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        // Revisar si el proceso fue exitoso
        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Contraseña restablecida con éxito.'], 200);
        }

        return response()->json(['message' => 'Ocurrió un error al restablecer la contraseña.'], 400);
    }
}
