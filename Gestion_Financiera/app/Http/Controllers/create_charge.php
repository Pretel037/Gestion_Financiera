<?php

// Función para crear un cargo
function createCharge($token, $amount, $email) {
    $requestCharge = new HttpRequest();
    $requestCharge->setUrl('https://secure.culqi.com/v2/charges');
    $requestCharge->setMethod(HTTP_METH_POST);

    $requestCharge->setHeaders([
        'Authorization' => 'Bearer pk_test_UTCQSGcXW8bCyU59', // Cambia a tu clave de API
        'Content-Type' => 'application/json'
    ]);

    $requestChargeBody = json_encode([
        "amount" => $amount,
        "currency_code" => "PEN", // Código de la moneda
        "email" => $email,
        "source_id" => $token, // Usar el token generado anteriormente
        "metadata" => [
            "producto" => "Nombre del producto",
            "dni" => "5831543"
        ]
    ]);

    $requestCharge->setBody($requestChargeBody);

    try {
        $responseCharge = $requestCharge->send();
        return json_decode($responseCharge->getBody(), true);
    } catch (HttpException $ex) {
        return ["error" => $ex->getMessage()];
    }
}

// Supongamos que el token se obtuvo previamente
$token = "TOKEN_OBTENIDO_DE_LA_CREACION_DEL_TOKEN"; // Debes obtener el token al crear el token
$amount = 10000; // Por ejemplo, 100.00 soles
$email = "ichard@piedpiper.com"; // Debe ser el mismo email utilizado al crear el token

// Llamar a la función para crear el cargo
$chargeResponse = createCharge($token, $amount, $email);

// Imprimir la respuesta del cargo
echo json_encode($chargeResponse);
