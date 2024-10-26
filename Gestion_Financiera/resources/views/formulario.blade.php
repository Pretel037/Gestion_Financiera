<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/formulario.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="custom-title">Bienvenido, ¿qué desea hacer hoy?</h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card payment-option" onclick="redirectToRoute('{{ route('voucher') }}')">
                    <img src="https://cdn-icons-png.flaticon.com/512/3200/3200751.png" alt="BCP Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Registrar un Pago</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card payment-option" onclick="redirectToRoute('{{ route('pagos1') }}')">
                    <img src="https://img.freepik.com/vector-premium/metodo-pago_7198-28.jpg" alt="Yape Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Pagar un Servicio</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card payment-option" onclick="redirectToRoute('{{ route('login') }}')">
                    <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" alt="Plin Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function redirectToRoute(route) {
            window.location.href = route;
        }
    </script>
</body>
</html>
