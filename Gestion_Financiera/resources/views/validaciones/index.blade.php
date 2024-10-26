@extends('index')
@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Vouchers</title>

    <!-- Estilos de Bootstrap y Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Estilos de SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
            color: #004581;
            margin-bottom: 30px;
        }
        .table-responsive {
            max-height: 800px;
            overflow-y: auto;
            margin-top: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .table {
            background-color: white;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
        }
        .table th {
            background-color: #004581;
            color: white;
            position: sticky;
            top: 0;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
        .table-hover tbody tr:hover {
            background-color: #d7ecff;
        }
        button {
            display: block;
            padding: 10px 20px;
            background-color: #018abd;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #016a95;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h1>Validación de Vouchers</h1>
        <div class="row">
            <div class="col-md-6">
                <p>Pagos SIGGA</p>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="pagos_sigga_table">
                        <thead>
                            <tr>
                                <th>N° Operacion</th>
                                <th>Monto</th>
                                <th>Fecha</th>
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
                <p>Voucher correspondiente</p>
                <div id="voucher_data" class="grid-item">
                
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery y SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</body>
@endsection
