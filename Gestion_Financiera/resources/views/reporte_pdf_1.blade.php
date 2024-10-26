<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cursos</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #f3f4f6;
            color: #1f2937;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .table td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #1f2937;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .date-range {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 15px;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="header">

            <h1 class="text-center mt-4">Balance de Ingresos - {{ $mes }}/{{ $año }}</h1>
            <h2 class="text-center">Número de alumnos: {{ $numeroVouchers }}</h2>
            <h2 class="text-center">Ingresos del mes: S/ {{ number_format($ingresosTotales, 2) }}</h2>
        
    </div>



        <h3 class="text-center mt-4">Resumen de pagos por día</h3>
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
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
</body>
</html>