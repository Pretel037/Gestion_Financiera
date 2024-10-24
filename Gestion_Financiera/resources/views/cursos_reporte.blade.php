@extends('index')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Cursos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
    
        body {

        font-family: 'Arial', sans-serif; 
 
        background-color: #f8f9fa;
            color: #333;
    }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        h1 {
            color: #007bff;
        }
        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .table {
            background-color: #ffffff;
            font-family: 'Montserrat', sans-serif;
        }
        .table thead th {
            background-color: #007bff;
            color: #ffffff;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,123,255,0.05);
        }
    </style>
</head>
<body>
    <div class="container-fluid"> 
        <h1 class="mb-4">Reporte de Cursos</h1>
        
        <form method="GET" action="{{ route('reportes.obtenerPagos') }}" class="mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="mes_actual" value="1" id="mesActual" {{ request('mes_actual') ? 'checked' : '' }}>
                        <label class="form-check-label" for="mesActual">
                            Mostrar solo mes actual
                        </label>
                    </div>
                </div>
                <div class="col-auto">
                    <label for="fechaInicio" class="form-label">Fecha Inicio:</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-auto">
                    <label for="fechaFin" class="form-label">Fecha Fin:</label>
                    <input type="date" class="form-control" id="fechaFin" name="fecha_fin" value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                            <td colspan="5" class="text-center">No se encontraron pagos para el criterio seleccionado.</td>
                        </tr>
                    @else
                        @foreach($pagos as $pago)
                            <tr>
                                <td>{{ $pago->nombre_curso_servicio }}</td>
                                <td>{{ $pago->numero_vouchers }}</td>
                                <td>{{ number_format($pago->total_monto, 2) }}</td>
                                <td>{{ $pago->numero_operacion }}</td>
                                <td>{{ $pago->first_name }} {{ $pago->last_name }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <form method="GET" action="{{ route('reportes.generarPDF') }}" class="mt-3">
            <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
            <button type="submit" class="btn btn-success">Generar PDF</button>
        </form>
        
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection