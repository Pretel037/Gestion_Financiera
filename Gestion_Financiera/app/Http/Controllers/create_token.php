<?php

// Función para crear un token
function createToken($cardData) {
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

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $cardData = [
        "card_number" => $_POST['card_number'], // Número de tarjeta
        "cvv" => $_POST['cvv'], // CVV
        "expiration_month" => $_POST['expiration_month'], // Mes de expiración
        "expiration_year" => $_POST['expiration_year'], // Año de expiración
        "email" => $_POST['email'], // Email
        "metadata" => [
            "dni" => $_POST['dni'] // Puedes pasar más metadatos si los tienes en el formulario
        ]
    ];

    // Llamar a la función para crear el token
    $tokenResponse = createToken($cardData);

    // Imprimir la respuesta
    echo json_encode($tokenResponse);
} else {
    echo json_encode(["error" => "Método no permitido."]);
}
