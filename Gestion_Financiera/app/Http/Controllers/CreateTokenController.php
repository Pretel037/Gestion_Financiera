<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use HttpRequest;

class CreateTokenController extends Controller
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

        // Lógica para crear el token usando Culqi
        $tokenResponse = $this->sendTokenRequest($validated); // Asegúrate de que esta función esté definida

        // Retornar la respuesta
        return response()->json($tokenResponse);
    }

    private function sendTokenRequest($cardData)
    {
        $request = new HttpRequest();
        $request->setUrl('https://secure.culqi.com/v2/tokens');
        $request->setMethod(HTTP_METH_POST);

        $request->setHeaders([
            'Authorization' => 'Bearer pk_test_a688d55bdc888bdd',
            'Content-Type' => 'application/json'
        ]);

        $request->setBody(json_encode($cardData));

        try {
            $response = $request->send();
            return json_decode($response->getBody(), true);
        } catch (HttpException $ex) {
            return ["error" => $ex->getMessage()];
        }
    }
}
