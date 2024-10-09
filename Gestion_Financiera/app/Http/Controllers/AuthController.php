<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios;
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
           // Redirigir a la ruta específica
           return redirect()->route('index');
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
