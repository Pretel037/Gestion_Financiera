<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Certificados PDF</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --background-color: #f1f5f9;
            --card-background: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
            line-height: 1.6;
        }

        h1, h2 {
            text-align: center;
        }

        h1 {
            color: #004581;
        }

        h2 {
            color: #018abd;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #e2e8f0;
            padding: 0.5rem;
            text-align: left;
        }

        .table th {
            background-color: #f8fafc;
            color: var(--text-primary);
        }

        .table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .total {
            font-weight: bold;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <h1>Reporte de Certificados</h1>
    <h2>Desde: {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} Hasta: {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre del Certificado</th>
                <th>Número de Operación</th>
                <th>Fecha de Pago</th>
                <th>Total Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->nombre_certificado }}</td>
                    <td>{{ $pago->numero_operacion }}</td>
                    <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                    <td>${{ number_format($pago->total_monto, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
