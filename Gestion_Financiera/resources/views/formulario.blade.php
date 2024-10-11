<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #dde8f0; 
      
            font-family: 'Montserrat', sans-serif;
        }
        h2 {
            color: #343a40; 
            text-align: center;
            font-weight: 600;
        }
        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px); 
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); 
        }
        .card img {
            max-height: 420px; 
            object-fit: cover;
            border-radius: 10px 10px 0 0; 
        }
        .card-title {
            color: #007bff;
            font-size: 1.25rem;
            font-weight: 500;
            text-align: center;
        }
        .payment-option.selected {
            border: 2px solid #007bff; 
        }
        .card-body {
            
            text-align: center;
        }
        .btn-custom {
            background-color: #007bff;
            color: rgb(73, 104, 255)55, 255, 255);
            border-radius: 20px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }

        .custom-title {
    color: #005089; 
    font-weight: bold; 
    text-transform: uppercase;
    text-align: center; 
    font-size: 28px; 
    font-family: 'Montserrat', sans-serif;
    padding-bottom: 10px; 
    margin-bottom: 20px; 
}
    </style>
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
                <div class="card payment-option" onclick="redirectToRoute('{{ route('payment.form') }}')">
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
