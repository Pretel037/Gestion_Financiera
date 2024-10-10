@extends('index')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vouchers Validados Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <h1 class="text-center">Vouchers Validados Table</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>N° operación</th>
                    <th>Fecha de pago</th>
                    <th>Monto</th>
                    <th>DNI/Código</th>
                    <th>Nombres</th>
                    <th>Nombre del curso/servicio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->numero_operacion }}</td>
                        <td>{{ $voucher->fecha_pago }}</td>
                        <td>{{ $voucher->monto }}</td>
                        <td>{{ $voucher->dni_codigo }}</td>
                        <td>{{ $voucher->nombres }}</td>
                        <td>{{ $voucher->nombre_curso_servicio }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
@endsection