<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
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
            <label for="email">Correos Electrónico</label>
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
