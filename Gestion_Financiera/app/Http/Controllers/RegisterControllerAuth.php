<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterControllerAuth extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Vista de registro
    }

    public function register(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Asegúrate de que hay un campo 'password_confirmation' en el formulario
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear el usuario
        Usuarios::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Cifrar la contraseña
        ]);

        // Autenticar al usuario después del registro
       // AuthController::login($user);

        return redirect()->route('login'); // Redirigir a la página deseada
    }
}
