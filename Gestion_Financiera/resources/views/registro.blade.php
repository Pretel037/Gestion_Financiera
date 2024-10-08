<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vouchers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Listado de Vouchers</h1>

        <div class="table-responsive">
            <table class="table table-striped table-hover">

                

                <thead class="table-vibrant">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Operación</th>
                        <th scope="col">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->id }}</td>
                            <td>{{ $voucher->fecha }}</td>
                            <td>{{ $voucher->hora }}</td>
                            <td>{{ $voucher->operacion }}</td>
                            <td>{{ $voucher->monto }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>