<!-- pdf_view.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Pagos</title>
    <style>
        /* Estilos para el PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Reporte de Pagos</h1>
    <table>
        <thead>
            <tr>
                <th>Cursos</th>
                <th>Número de Vouchers</th>
                <th>Total Monto</th>
                <th>Números de Operación</th>
                <th>Profesores</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->nombre_curso_servicio }}</td>
                    <td>{{ $pago->numero_vouchers }}</td>
                    <td>{{ $pago->total_monto }}</td>
                    <td>{{ $pago->numero_operacion }}</td>
                    <td>{{ $pago->first_name }} {{ $pago->last_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
