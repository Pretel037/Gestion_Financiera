@extends('index')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vouchers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif; 
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
            color: #004581;
            margin-bottom: 30px;
            font-family: 'Montserrat', sans-serif;
        }
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .table {
            background-color: white;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
        }
        .table th {
            background-color: #004581;
            color: white;
            position: sticky;
            top: 0;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
        .table-hover tbody tr:hover {
            background-color: #d7ecff;
        }
        .search-group {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .search-label {
            background-color: #004581;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            min-width: 120px;
            text-align: center;
            margin: 0;
            font-weight: 500;
        }
        .form-control {
            flex: 1;
        }
        .search-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container-fluid"> 
        <h1 class="mb-4">Vouchers Registrados por Alumnos</h1>

        <form method="GET" action="{{ route('registro') }}" class="search-container">
            <div class="search-group">
                <span class="search-label">Fecha Inicio</span>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>

            <div class="search-group">
                <span class="search-label">Fecha Fin</span>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>

            <div class="search-group">
                <span class="search-label">DNI</span>
                <input type="text" name="codigo_dni" class="form-control" placeholder="Ingrese DNI" value="{{ $codigoDNI }}">
            </div>

            <div class="search-group">
                <span class="search-label">N° Operación</span>
                <input type="text" name="numero_operacion" class="form-control" placeholder="Ingrese número de operación" value="{{ $numeroOperacion }}">
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-4">Buscar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Operación</th>
                        <th scope="col">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->id }}</td>
                            <td>{{ $voucher->fecha }}</td>
                            <td>{{ $voucher->hora }}</td>
                            <td>{{ $voucher->operacion }}</td>
                            <td>S/ {{ number_format($voucher->monto, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection