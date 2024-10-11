<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #dde8f0; 
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 80%;
        }

        h2 {
            color: #007BFF;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #007BFF;;
            border-color: #007BFF;
            border-radius: 10px;
            width: 80%;
            padding: 10px;
            margin-right: 30px; 
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            border-radius: 10px;
            background-color: #2ccbeb;
            border-color: #2ccbeb;
            font-color:  #000dff;;
        }
        .btn-secondary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .d-flex {
            justify-content: space-between;
        }

        .alert {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Iniciar Sesión</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ url('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <!-- Flex container for buttons -->
        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <a href="{{ route('inicio') }}" class="btn btn-secondary">Volver a la Página Inicial</a>
        </div>
    </form>
</div>
</body>
</html>
