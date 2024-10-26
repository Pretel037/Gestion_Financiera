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
        <h1>Reporte de Cursos</h1>
        @if(isset($fechaInicio) && isset($fechaFin))
            <div class="date-range">
                Período: {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
            </div>
        @else
            <div class="date-range">
                Mes: {{ \Carbon\Carbon::now()->format('F Y') }}
            </div>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Número de Vouchers</th>
                <th>Total Monto</th>
                <th>Números de Operación</th>
                <th>Profesor</th>
            </tr>
        </thead>
        <tbody>
            @if($pagos->isEmpty())
                <tr>
                    <td colspan="5" style="text-align: center;">No se encontraron pagos para el período seleccionado.</td>
                </tr>
            @else
                @foreach($pagos as $pago)
                    <tr>
                        <td>{{ $pago->nombre_curso_servicio }}</td>
                        <td>{{ $pago->numero_vouchers }}</td>
                        <td>S/ {{ number_format($pago->total_monto, 2) }}</td>
                        <td>{{ $pago->numero_operacion }}</td>
                        <td>{{ $pago->first_name }} {{ $pago->last_name }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td>Total</td>
                    <td>{{ $pagos->sum('numero_vouchers') }}</td>
                    <td>S/ {{ number_format($pagos->sum('total_monto'), 2) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>