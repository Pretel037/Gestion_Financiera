@extends('index')
@section('content')

<style>
    .table {
    border-collapse: collapse; 
}

.table th, .table td {
    padding: 10px; 
    text-align: center; 
    border: 1px solid #dee2e6; 
}

.table th {
    background-color: #007bff; 
    color: white; 
}

.btn {
    margin-top: 5px; 
    transition: background-color 0.3s; 
}

.btn:hover {
    background-color: #0056b3; 
}

</style>
@if($voucher)
<div class="container-fluid"> 
<section class="voucher-section">
    <h4>Detalles del Voucher</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Numero Operacion</th>
                <th>Código DNI</th>
                <th>Servicio</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $voucher->operacion }}</td>
                <td>{{ $voucher->codigo_dni }}</td>
                <td>{{ $voucher->servicio }}</td>
                <td>{{ $voucher->monto }}</td>
                <td>{{ $voucher->fecha }}</td>
                <td>
                    <button class="btn btn-success" id="insertar_validacion"
                        data-voucher-id="{{ $voucher->id }}"
                        data-pagos-sigga-id="{{ $pagoSigga->id }}">
                        <i class="fas fa-check"></i> Validar y Registrar
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</section>
</div>
@else
<section class="no-voucher">
    <p>No se encontró un voucher que coincida.</p>
</section>
@endif

@endsection