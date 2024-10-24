@extends('index')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Excel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0; 
            padding: 0; 
            font-family: 'Arial', sans-serif; 
            height: 100%; 
            overflow: hidden; 
            background-color: #f5f7fa; 
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); 
        }
        .card-header {
            background-color: #004581; 
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .card-header h1 {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }
        .btn-primary {
            background-color: #018abd;
            border-color: #018abd;
            font-size: 1rem;
            font-weight: bold;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #016a95; 
        }
        .form-label {
            font-weight: bold;
        }
        .alert {
            margin-top: 10px;
            border-radius: 8px;
        }
        .d-grid {
            margin-top: 20px;
        }
        .file-input-label {
            display: block;
            margin-bottom: 10px;
        }
        .file-input {
            display: block;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ced4da;
        }

        .main-content {
    margin-left: 140px;
    background-color: #ffffff;
    width: calc(100% - 140px);
    height: calc(100%);
    overflow-y: auto;
}
    </style>
</head>

    <div class="container-fluid"> 
                <div class="card">
                    <div class="card-header text-white">
                        <h1 class="mb-0"><i class="fa-solid fa-file-excel me-2"></i>Importar archivo Excel</h1>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger" role="alert">
                                <i class="fa-solid fa-times-circle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('pagos.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Seleccionar archivo Excel:</label>
                                <input class="form-control file-input" type="file" name="file" id="file" accept=".xlsx,.xls" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-upload me-2"></i>Subir archivo</button>
                            </div>
                        </form>
                    </div>
                </div>
        
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</html>
@endsection
