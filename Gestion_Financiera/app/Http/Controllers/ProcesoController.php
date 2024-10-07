<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Culqi\culqi;
use Exception;
class ProcesoController extends Controller
{
	private $culqi;

    public function __construct()
    {
        $SECRET_KEY = "sk_test_43b8872ae6af27f6";
        $this->culqi = new Culqi(['api_key' => $SECRET_KEY]);
    }

    public function proceso(Request $request)
    {
        try {
            $charge = $this->culqi->Charges->create([
                "amount" => $request->input('precio'),
                "capture" => true,
                "currency_code" => "PEN",
                "description" => $request->input('producto'),
                "customer_id" => $request->input('customer_id'),
                "address" => $request->input('address'),
                "address_city" => $request->input('address_city'),
                "first_name" => $request->input('first_name'),
                "email" => $request->input('email'),
                "installments" => 0,
                "source_id" => $request->input('token')
            ]);

            return response()->json('exito', 200);

        } catch (Exception $e) {
            return response()->json('error: ' . $e->getMessage(), 400);
        }
    }
	

}