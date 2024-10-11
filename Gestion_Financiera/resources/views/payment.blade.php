<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Pago con Culqi</title>
</head>
<body>

    <h1>Realizar Pago</h1>


    <form id="payment-form">
        <label for="card_number">Número de tarjeta:</label>
        <input type="text" id="card_number" name="card_number" maxlength="16" required><br><br>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" maxlength="3" required><br><br>

        <label for="exp_month">Mes de Expiración (MM):</label>
        <input type="text" id="exp_month" name="exp_month" maxlength="2" required><br><br>

        <label for="exp_year">Año de Expiración (YY):</label>
        <input type="text" id="exp_year" name="exp_year" maxlength="2" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="button" id="payButton">Pagar</button>
    </form>

    <!-- Culqi.js para generar el token -->
    <script src="https://checkout.culqi.com/js/v3"></script>

    <script>
        // Inicializar Culqi con la Public Key
        Culqi.publicKey = '{{ env("pk_test_a688d55bdc888bdd") }}';

        document.getElementById('payButton').addEventListener('click', function (e) {
            e.preventDefault();

            // Generar el token de Culqi
            Culqi.createToken({
                card_number: document.getElementById('card_number').value,
                cvv: document.getElementById('cvv').value,
                expiration_month: document.getElementById('exp_month').value,
                expiration_year: document.getElementById('exp_year').value,
                email: document.getElementById('email').value,
            });

            // Función llamada cuando el token es generado
            function culqi() {
                if (Culqi.token) {
                    // Token generado correctamente
                    const token = Culqi.token.id;

                    // Llamar a tu backend para procesar el pago
                    fetch('/process-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            token: token,
                            amount: 1000,  // Monto en centavos (S/. 10.00)
                            email: document.getElementById('email').value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Pago realizado con éxito');
                        } else {
                            alert('Error en el pago: ' + data.message);
                        }
                    });
                } else {
                    // Mostrar error si el token no se genera
                    console.error(Culqi.error);
                    alert('Error: ' + Culqi.error.user_message);
                }
            }
        });
    </script>

</body>
</html>
