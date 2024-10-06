<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use HttpRequest; // Asegúrate de tener la clase correcta para las solicitudes HTTP

class TokenController extends Controller
{
    public function createToken(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'card_number' => 'required|string',
            'cvv' => 'required|string',
            'expiration_month' => 'required|integer',
            'expiration_year' => 'required|integer',
            'email' => 'required|email',
            'dni' => 'required|string',
        ]);

        // Llamar a la función para crear el token
        $tokenResponse = $this->sendTokenRequest($validated);

        // Retornar la respuesta
        return response()->json($tokenResponse);
    }

    // Función para crear el token
    private function sendTokenRequest($cardData)
    {
        $request = new HttpRequest();
        $request->setUrl('https://secure.culqi.com/v2/tokens');
        $request->setMethod(HTTP_METH_POST);

        $request->setHeaders([
            'Authorization' => 'Bearer pk_test_a688d55bdc888bdd', // Cambia a tu clave de API
            'Content-Type' => 'application/json'
        ]);

        // Cuerpo de la solicitud con la información de la tarjeta
        $request->setBody(json_encode($cardData));

        try {
            $response = $request->send();
            return json_decode($response->getBody(), true);
        } catch (HttpException $ex) {
            return ["error" => $ex->getMessage()];
        }
    }
}

