<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Culqi\Culqi; // Asegúrate de que la clase Culqi está correctamente importada.

class ProcesoController extends Controller
{
    public function procesos(Request $request)
    {
        require 'requests/library/Requests.php';
        Requests::register_autoloader();
        require 'culqi/lib/culqi.php';
    
        // Configurar tu API Key y autenticación
        $SECRET_KEY = "sk_test_43b8872ae6af27f6";
        $culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));
    
        try {
            // Crear el cargo
            $charge = $culqi->Charges->create(array(
                "amount" => $request->input('precio'),
                "currency_code" => "PEN",
                "description" => $request->input('producto'),
                "customer_id" => $request->input('customer_id'),
                "address" => $request->input('address'),
                "address_city" => $request->input('address_city'),
                "first_name" => $request->input('first_name'),
                "email" => $request->input('email'),
                "installments" => 0,
                "source_id" => $request->input('token'),
            ));
    
            return response()->json(['status' => 'exito', 'data' => $charge]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
