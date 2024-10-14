@extends('index')
@section('content')
<style>
body {
    background-color: #f8f9fa; 
    font-family: 'Arial', sans-serif; 
}

.container {
    margin-top: 20px; 
    padding: 20px;
    background-color: white;
    border-radius: 8px; 
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
}

h2 {
    color: #007bff; 
    text-align: center; 
}

.table {
    border-collapse: collapse; 
    width: 80%; 
}

.table th, .table td {
    padding: 10px; 
    text-align: center;
}

.table th {
    background-color: #007bff;
    color: white; 
    border-bottom: 2px solid #dee2e6; 
}

.table td {
    border-bottom: 1px solid #dee2e6; 
}

.btn {
    margin-top: 5px; 
}


.table-container {
    display: flex;
    justify-content: center; 
    align-items: center;
    margin-top: 10px;
}

/* Estilo para las alertas */
.swal2-popup {
    font-size: 1.2em; 
}

.row {
    display: flex; 
    justify-content: space-between; 
    flex-wrap: wrap; 
}

.col-md-6 {
    flex: 1;
    margin: 10px;
    min-width: 300px; 
}

.grid-container {
    display: grid; 
    grid-template-columns: repeat(2, 1fr); 
    gap: 5px; 
}

.grid-item {
    background: #fff;
    padding: 15px;
    border: 1px solid #dee2e6;
    border-radius: 5px;
}
</style>

<head>

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
