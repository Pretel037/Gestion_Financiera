<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con Culqi</title>
    <script src="https://checkout.culqi.com/js/v3"></script>
</head>
<body>
    <h1>Pagar con Culqi</h1>

    <form id="payment-form">
        <input type="text" id="card_number" placeholder="Número de tarjeta" required>
        <input type="text" id="cvv" placeholder="CVV" required>
        <input type="text" id="exp_month" placeholder="Mes de expiración" required>
        <input type="text" id="exp_year" placeholder="Año de expiración" required>
       
        <button type="button" id="pay-button">Pagar</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar Culqi con tu API Key pública
            Culqi.publicKey = 'pk_test_a688d55bdc888bdd'; // Reemplaza con tu llave pública

            document.getElementById('pay-button').addEventListener('click', function(e) {
                e.preventDefault(); // Prevenir que el botón envíe el formulario por defecto

                const cardNumber = document.getElementById('card_number');
                const cvv = document.getElementById('cvv');
                const expMonth = document.getElementById('exp_month');
                const expYear = document.getElementById('exp_year');
               

                // Comprobar si los elementos existen
                if (!cardNumber || !cvv || !expMonth || !expYear) {
                    console.error('Uno o más elementos no se encontraron.');
                    return;
                }

                // Crear token usando los datos de la tarjeta
                Culqi.createToken({
                    card_number: cardNumber.value,
                    cvv: cvv.value,
                    expiration_month: expMonth.value,
                    expiration_year: expYear.value,

                });

                console.log('Intentando generar el token...');
            });

            // Esta función se llama automáticamente cuando Culqi genera el token
            window.culqi = function() {
                if (Culqi.token) {
                    console.log('Token generado:', Culqi.token.id);
                    // Enviar el token al servidor para procesar el pago
                } else {
                    console.error(Culqi.error.user_message);
                }
            };
        });
    </script>
</body>
</html>
