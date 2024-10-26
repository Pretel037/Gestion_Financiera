
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éxito</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            background: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #28a745;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .icon {
            font-size: 50px;
            color: #28a745;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <i class="fas fa-check-circle icon"></i>
        <h1>¡Pago Realizado Correctamente!</h1>
        <a href="{{ route('inicio') }}">Volver</a>
    </div>
</body>
</html>
