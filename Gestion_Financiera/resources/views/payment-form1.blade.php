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
  

    background-color: #00c8ff;
    color: #ffff;
    border-radius: 20px;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
}
.btn-custom:hover {
    background-color: #e4efff;
    color: #00c8ff;
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
                <div class="card payment-option" onclick="redirectToRoute('{{ route('payment.form1') }}')">
                    <img src="https://cdn-icons-png.flaticon.com/512/4078/4078099.png" alt="BCP Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Pagar Matricula</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card payment-option" onclick="redirectToRoute('{{ route('payment.form') }}')">
                    <img src="https://cdn-icons-png.flaticon.com/512/5352/5352122.png" alt="Yape Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Pagar un Curso</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card payment-option" onclick="redirectToRoute('{{ route('payment.form2') }}')">
                    <img src="https://cdn-icons-png.flaticon.com/512/7238/7238700.png" alt="Plin Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Pagar Cerificado</h5>
                    </div>
                </div>
            </div>

            <a href="{{ route('inicio') }}" class="btn btn-custom">Volver a la Página Inicial</a>
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
