

@if($voucher)
<div class="container-fluid"> 
<section class="voucher-section">
    <h1>Detalles del Voucher</h4>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>N° Operacion</th>
                    <th>Código</th>
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
    </div>
</section>
</div>
@else
<section class="no-voucher">
    <p>No se encontró un voucher que coincida.</p>
</section>
@endif
