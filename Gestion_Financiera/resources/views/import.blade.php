<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Excel</title>
</head>
<body>
    <h1>Importar archivo Excel</h1>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('pagos.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Seleccionar archivo Excel:</label>
        <input type="file" name="file" id="file" required>
        <br><br>
        <button type="submit">Subir archivo</button>
    </form>
</body>
</html>

