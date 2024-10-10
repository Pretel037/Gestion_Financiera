@extends('index')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ingresos</title>
    <style>
        body { font-family: sans-serif; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Balance de Ingresos - {{ $mes }}/{{ $año }}</h1>
    <h2>Número de alumnos: {{ $numeroVouchers }}</h2>
    <h2>Ingresos del mes: S/ {{ number_format($ingresosTotales, 2) }}</h2>

    <h3>Resumen de pagos por día</h3>
    <table>
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
        <button type="submit">Descargar PDF</button>
    </form>
</body>
</html>
@endsection