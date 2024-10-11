<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Método de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
/*#dde8f0*/
body {
            background-color: #ffffff; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        .payment-option {
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .payment-option.selected {
            border: 2px solid #007bff;
        }

        
        .btn-custom {
    background-color: #018abd;
    border-color: #018abd;
    color: white;
    font-size: 18px;
    font-weight: bold;
    padding: 10px 20px;
}


.btn-custom:hover {
    background-color: #018abd;
    border-color: #018abd;
    color: white;
}


.btn-custom:focus {
    background-color: #018abd;
    border-color: #018abd;
    color: white;
    outline: none; 
}

.btn-custom:active {
    background-color: #0174a3; 
    border-color: #0174a3;
    color: white;
}

.custom-title {
    color: #005089; 
    font-weight: bold; 
    text-transform: uppercase; 
    text-align: center; 
    font-size: 28px; 
    
    padding-bottom: 10px; 
    margin-bottom: 20px; 
}

.btn-process {
    background-color: #018abd; 
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
}

.btn-process:hover {
    background-color: #0174a3; 
}
.container {
    margin-bottom: 50px; 



    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="custom-title">Seleccione el tipo de voucher</h2>

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card payment-option" onclick="selectPayment('bcp')">
                    <img src="https://play-lh.googleusercontent.com/VmEDA548jPYQVBNrWYb1ZNqAr-opQbRBrxIjKBHmS9kVX4tD1hh6LkzVzxSR0TXhiK0" alt="BCP Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Pagalo Pe</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card payment-option" onclick="selectPayment('yape')">
                    <img src="https://yt3.googleusercontent.com/l048nvZUXxmhjaDjxdJntZWSj03oOAK0ETKCQZup-Ea-aM_h8M94Jz87cw8JiwCHSEbv8llH=s900-c-k-c0x00ffffff-no-rj" alt="Yape Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Yape</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card payment-option" onclick="selectPayment('plin')">
                    <img src="https://yt3.googleusercontent.com/TaU2FLGf17S_L0OREVzdmLa2fS52bC9d0tCHCTZEz0cMyaQg2rLmBDn6Pqxbh268C_qbwuWWEw=s900-c-k-c0x00ffffff-no-rj" alt="Plin Logo" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Plin</h5>
                    </div>
                </div>
            </div>
            <a href="{{ route('inicio') }}" class="btn btn-custom">Volver a la Página Inicial</a>

        </div>

        <div id="voucherForm" class="mt-4" style="display: none;">
            <h3 class="mb-3">Subir Voucher</h3>
            <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="voucher_image" class="form-label">Subir imagen del voucher:</label>
                    <input type="file" class="form-control" name="voucher_image" id="voucher_image" required>
                </div>
                <button type="submit" class="btn-process">Procesar</button>

            </form>
        
        </div>
        

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       function selectPayment(method) {
    document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.payment-option[onclick="selectPayment('${method}')"]`).classList.add('selected');

    const form = document.getElementById('uploadForm');
    switch(method) {
        case 'bcp':
            form.action = "{{ route('voucher.process') }}";
            break;
        case 'yape':
            form.action = "{{ route('voucher.processyape') }}";
            break;
        case 'plin':
            form.action = "{{ route('voucher.processplin') }}";
            break;
    }

    // Mostrar el formulario
    document.getElementById('voucherForm').style.display = 'block';

    // Desplazar automáticamente al formulario
    document.getElementById('voucherForm').scrollIntoView({ behavior: 'smooth' });
}

    </script>
</body>


</html>