@extends('index')
@section('content')
<style>
body {
    background-color: #f8f9fa; /* Fondo claro */
    font-family: 'Arial', sans-serif; /* Fuente más legible */
}

.container {
    margin-top: 20px; /* Espaciado superior */
    padding: 20px;
    background-color: white; /* Fondo blanco para la sección principal */
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra sutil */
}

h2 {
    color: #007bff; /* Color del encabezado */
    text-align: center; /* Centrar el título */
}

.table {
    border-collapse: collapse; /* Colapsa bordes */
    width: 80%; /* Ancho completo */
}

.table th, .table td {
    padding: 10px; /* Espaciado interno */
    text-align: center; /* Centrar texto */
}

.table th {
    background-color: #007bff; /* Color de fondo de encabezado */
    color: white; /* Color del texto de encabezado */
    border-bottom: 2px solid #dee2e6; /* Línea inferior para separar el encabezado */
}

.table td {
    border-bottom: 1px solid #dee2e6; /* Línea inferior sutil para las celdas */
}

.btn {
    margin-top: 5px; /* Espaciado superior en botones */
}

/* Centrar tablas en el contenedor */
.table-container {
    display: flex;
    justify-content: center; /* Centrar horizontalmente */
    align-items: center;
    margin-top: 10px;
}

/* Estilo para las alertas */
.swal2-popup {
    font-size: 1.2em; /* Tamaño de fuente más grande para alertas */
}

.row {
    display: flex; /* Habilita el diseño flex */
    justify-content: space-between; /* Espacia las columnas equitativamente */
    flex-wrap: wrap; /* Asegura que las columnas se adapten a pantallas pequeñas */
}

.col-md-6 {
    flex: 1;
    margin: 10px;
    min-width: 300px; /* Evita que las columnas sean demasiado pequeñas */
}

.grid-container {
    display: grid; /* Habilita el diseño de cuadrícula */
    grid-template-columns: repeat(2, 1fr); /* Dos columnas de igual tamaño */
    gap: 5px; /* Espacio entre las columnas */
}

.grid-item {
    background: #fff;
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: 5px;
}
</style>

<head>
    <!-- Otros enlaces de CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="container-fluid"> 
    <h2>Validación de Vouchers</h2>
    <div class="row">
        <div class="col-md-6">
            <h4>  .             Pagos SIGGA</h4>
            <div class="table-container">
                <table class="table table-bordered" id="pagos_sigga_table">
                    <thead>
                        <tr>
                            <th>Numero Operacion</th>
                            <th>Monto</th>
                            <th>Fecha Pago</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pagosSigga as $pago)
                        <tr>
                            <td>{{ $pago->numero_operacion }}</td>
                            <td>{{ $pago->monto_pago }}</td>
                            <td>{{ $pago->fecha_pago }}</td>
                            <td>
                                <button class="btn btn-primary validar-voucher" 
                                    data-numero="{{ $pago->numero_operacion }}"
                                    data-monto="{{ $pago->monto_pago }}"
                                    data-fecha="{{ $pago->fecha_pago }}">
                                    Validar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <h4>Voucher correspondiente</h4>
            <div id="voucher_data" class="grid-item">
                <!-- Aquí se mostrará la fila del voucher correspondiente -->
            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click', '.validar-voucher', function() {
    let numeroOperacion = $(this).data('numero');
    let monto = $(this).data('monto');
    let fechaPago = $(this).data('fecha');

    $.ajax({
        url: '{{ route("buscar.voucher") }}',
        method: 'GET',
        data: {
            numero_operacion: numeroOperacion,
            monto: monto,
            fecha_pago: fechaPago,
        },
        success: function(response) {
            if (response.success) {
                $('#voucher_data').html(response.voucher);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });
            }
        }
    });
});

$(document).on('click', '#insertar_validacion', function() {
    let voucherId = $(this).data('voucher-id');
    let pagosSiggaId = $(this).data('pagos-sigga-id');

    $.ajax({
        url: '{{ route("validar.voucher") }}',
        method: 'POST',
        data: {
            voucher_id: voucherId,
            pagos_siga_id: pagosSiggaId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message,
                });
                // Aquí puedes actualizar la UI si es necesario
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + response.message,
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON.message,
            });
        }
    });
});
</script>
@endsection
