<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Handle an authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->only('email', 'password');

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            // Si las credenciales son correctas, obtener el usuario autenticado
            $user = Auth::user();

            // Si usas Sanctum, puedes generar un token aquí
            $token = $user->createToken('Inventarios')->plainTextToken;

            // Responder con los datos del usuario y el token
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,  // Devolver el token si usas Sanctum
            ]);
        } else {
            // Si las credenciales no son correctas, devolver un mensaje de error
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
    }
    
    public function logout(Request $request)
{
    // Revocar el token actual del usuario
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logged out successfully'
    ]);
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
