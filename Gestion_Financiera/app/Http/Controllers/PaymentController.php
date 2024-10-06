<?php

namespace App\Http\Controllers;

use Culqi\Culqi;
use Culqi\CulqiException;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
          
            $culqi = new Culqi([
                'api_key' => env('CULQI_SECRET_KEY')
            ]);

            // Crear un token utilizando los datos enviados desde el frontend (tarjeta, etc.)
            $token = $request->input('token'); // Token enviado desde el cliente

            // Crear un cargo (Payment)
            $charge = $culqi->Charges->create([
                "amount" => $request->input('amount'), // Monto en centavos (1000 = S/. 10.00)
                "currency_code" => "PEN", // Moneda en Soles peruanos
                "email" => $request->input('email'), // Correo del cliente
                "source_id" => $token, // El token de la tarjeta generado en el frontend
                "description" => "Pago de ejemplo en Laravel"
            ]);

            // Devolver una respuesta satisfactoria
            return response()->json([
                'status' => 'success',
                'message' => 'Pago realizado con éxito',
                'charge' => $charge
            ]);
        } catch (CulqiException $e) {
            // Manejar errores
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error inesperado al procesar el pago.'
            ]);
        }
    }
}
