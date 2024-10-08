<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Voucher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Datos extraídos del voucher</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Número de operación:</strong> {{ $sequence }}</p>
                        <p><strong>Fecha de Pago:</strong> {{ $operationDate }}</p>
                        <p><strong>Hora de Pago:</strong> {{ $operationTime }}</p>
                        <p><strong>Tipo de Documento:</strong> {{ $documentType }}</p>
                        <p><strong>Código:</strong> {{ $code }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> {{ $name }}</p>
                        <p><strong>Secuencia de Pago:</strong> {{ $sequence }}</p>
                        <p><strong>Monto de Pago:</strong> {{ $totalAmount }}</p>
                        <p><strong>Número de Ticket:</strong> {{ $TICKET }}</p>
                        <p><strong>Concepto de Pago:</strong> {{ $CONCEPTO }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>