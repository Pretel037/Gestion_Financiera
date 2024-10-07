<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Culqi\Culqi;

class CulqiController extends Controller
{
    private $culqi;

    public function __construct()
    {
        $this->culqi = new Culqi(['api_key' => env('CULQI_SECRET_KEY')]);
    }

    public function showPaymentForm()
    {
        $data = [
            'sid' => session()->getId(),
            'totCart' => 10,
            'dni_comp' => '72042683',
            'direccion' => 'Francisco Lazo',
            'departamento' => 'Lima',
            'provincia' => 'Lima',
            'nombre_comp' => 'Frank Moreno Alburqueque',
            'correo_comp' => 'admin@frankmorenoalburqueque.com',
        ];

        return view('payment-form', $data);
    }

    public function processPayment(Request $request)
    {
        try {
            $charge = $this->culqi->Charges->create([
                "amount" => $request->precio,
                "capture" => true,
                "currency_code" => "PEN",
                "description" => $request->producto,
                "customer_id" => $request->customer_id,
                "address" => $request->address,
                "address_city" => $request->address_city,
                "first_name" => $request->first_name,
                "email" => $request->email,
                "installments" => 0,
                "source_id" => $request->token
            ]);

            return response()->json(['status' => 'success', 'message' => 'Pago realizado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}