@extends('index')
@section('content')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Certificados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    font-size: 16px;
    font-family: 'Montserrat', sans-serif;
    background-color: var(--background-color);
    color: var(--text-primary);
    line-height: 1.6;
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

        .page-container {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

        .filter-card {
            background-color: var(--card-background);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .form-control, .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            border-color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-1px);
        }

        .table-container {
            background-color: var(--card-background);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8fafc;
            color: var(--text-primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
            padding: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: var(--text-secondary);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8fafc;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f5f9;
            transition: background-color 0.3s ease;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="dashboard-header">
            <h1>Reporte de Certificados</h1>
        </div>

        <div class="filter-card">
            <h2>Filtrar por Fecha</h2>
            <form action="{{ route('reportes.obtenerPagos1') }}" method="GET">
                <div class="form-group">
                    <input type="date" name="fecha_inicio" class="form-control" placeholder="Fecha Inicio" required>
                    <input type="date" name="fecha_fin" class="form-control" placeholder="Fecha Fin" required>
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    <a href="{{ route('reportes.generarPDF1', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                </div>
            </form>
        </div>

        <div class="table-container">
            @if($pagos->isEmpty())
                <div class="empty-state">No hay registros para mostrar.</div>
            @else
                <table class="table table-striped table-hover">
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
            @endif
        </div>
    </div>
</body>
</html>
@endsection
