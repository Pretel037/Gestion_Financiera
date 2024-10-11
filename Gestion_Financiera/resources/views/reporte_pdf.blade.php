@extends('index')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ingresos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f7f9fc;
            color: #333;
        }
        h1, h2 {
            text-align: center;
            margin-top: 20px;
        }
        h1 {
            color: #004581; 
        }
        h2 {
            color: #018abd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #e5e5e5;
        }
        th {
            background-color: #004581;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9f5ff;
        }
      
        button {
            display: block;
            margin: 30px auto;
            padding: 10px 20px;
            background-color: #018abd;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #016a95;
        }
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }
            th, td {
                padding: 8px;
            }
            button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid"> 
        <h1>Balance de Ingresos - {{ $mes }}/{{ $año }}</h1>
        <h2>Número de alumnos: {{ $numeroVouchers }}</h2>
        <h2>Ingresos del mes: S/ {{ number_format($ingresosTotales, 2) }}</h2>

        <h3 class="text-center mt-4">Resumen de pagos por día</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Día</th>
                    <th>Número de Vouchers</th>
                    <th>Monto Total (S/)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dias as $index => $dia)
                    <tr>
                        <td>{{ $dia }}</td>
                        <td>{{ $numeroVouchersPorDia[$index] }}</td>
                        <td>S/ {{ number_format($montosPorDia[$index], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón para descargar el PDF -->
        <form action="{{ route('descargarPDF') }}" method="POST">
            @csrf
            <input type="hidden" name="mes" value="{{ $mes }}">
            <input type="hidden" name="año" value="{{ $año }}">
            <button type="submit">
                <i class="fa fa-download"></i> Descargar PDF
            </button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
