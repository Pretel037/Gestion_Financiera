@extends('index')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vouchers Validados</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif; 
            overflow: hidden; 
        }
        h1 {
            color: #004581;
            font-family: 'Arial', sans-serif; 
        }
        .table {
            background-color: white;
            box-shadow: 0 4px 8px rgba(255, 255, 255);
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            margin-top: 20px;
        }
        .table th {
            background-color: #004581;
            color: white;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #ffffff;
        }
        .table-hover tbody tr:hover {
            background-color: #d7ecff;
        }
        .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h1 class="text-center">Vouchers Validados</h1>
        
        <!-- Formulario de búsqueda -->
        <form method="GET" action="{{ route('vouchers') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="numero_operacion" class="form-control" placeholder="N° operación" value="{{ request('numero_operacion') }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="codigo_dni" class="form-control" placeholder="DNI/Código" value="{{ request('codigo_dni') }}">
                </div>
                <div class="col-md-4">
                    <input type="date" name="fecha_pago" class="form-control" value="{{ request('fecha_pago') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Buscar</button>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">N° operación</th>
                        <th scope="col">Fecha de pago</th>
                        <th scope="col">Monto (S/)</th>
                        <th scope="col">DNI/Código</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Curso/Servicio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->numero_operacion }}</td>
                            <td>{{ $voucher->fecha_pago }}</td>
                            <td>S/ {{ number_format($voucher->monto, 2) }}</td>
                            <td>{{ $voucher->dni_codigo }}</td>
                            <td>{{ $voucher->nombres }}</td>
                            <td>{{ $voucher->nombre_curso_servicio }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
