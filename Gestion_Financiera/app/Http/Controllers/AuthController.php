<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Muestra el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Maneja el inicio de sesión
    public function login(Request $request)
    {
        // Validar las credenciales
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Verificar si el usuario autenticado tiene el rol de admin
            if (Auth::user()->role === 'admin') {
                // Redirigir a la ruta específica si es admin
                return redirect()->route('index');
            } else {
                // Cerrar la sesión si el rol no es admin
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Acceso denegado. Solo los administradores pueden iniciar sesión.',
                ]);
            }
        }

        // Si las credenciales son incorrectas, redirigir de nuevo al formulario
        return redirect()->back()->withErrors([
            'email' => 'Las credenciales son incorrectas.',
        ]);
    }

    // Manejar el cierre de sesión
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
