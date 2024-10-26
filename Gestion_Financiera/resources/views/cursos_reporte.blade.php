@extends('index')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Cursos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .page-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-header {
            margin-bottom: 2rem;
            padding: 1rem 0;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .dashboard-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: var(--accent-color);
            border-radius: 2px;
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

        .btn-success {
            background-color: #059669;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #047857;
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

        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            margin-top: 0.3rem;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-secondary);
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

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 1rem;
            }

            .dashboard-title {
                font-size: 1.5rem;
            }

            .filter-card {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Reporte de Cursos</h1>
        </div>
        
        <div class="filter-card">
            <form method="GET" action="{{ route('reportes.obtenerPagos') }}" class="row g-3">
                <div class="col-12 col-md-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="mes_actual" value="1" id="mesActual" {{ request('mes_actual') ? 'checked' : '' }}>
                        <label class="form-check-label" for="mesActual">
                            Mostrar solo mes actual
                        </label>
                    </div>
                </div>
                <div class="col-12 col-md-auto">
                    <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-12 col-md-auto">
                    <label for="fechaFin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="fechaFin" name="fecha_fin" value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-12 col-md-auto align-self-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
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
                                <td colspan="5" class="empty-state">
                                    <i class="fas fa-search fa-2x mb-3 text-secondary"></i>
                                    <p class="mb-0">No se encontraron pagos para el criterio seleccionado.</p>
                                </td>
                            </tr>
                        @else
                            @foreach($pagos as $pago)
                                <tr>
                                    <td>{{ $pago->nombre_curso_servicio }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $pago->numero_vouchers }}</span>
                                    </td>
                                    <td>S/ {{ number_format($pago->total_monto, 2) }}</td>
                                    <td>{{ $pago->numero_operacion }}</td>
                                    <td>
                                        <i class="fas fa-user-tie me-2 text-secondary"></i>
                                        {{ $pago->first_name }} {{ $pago->last_name }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="action-buttons">
            <form method="GET" action="{{ route('reportes.generarPDF') }}">
                <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection