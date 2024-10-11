@extends('index')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

<style>
    .form-group {
        margin-bottom: 15px;
        font-family: 'Montserrat', sans-serif;
        padding: 1%;
    }
    h2 {
        text-align: center;
        color: #004581;
        
        margin-bottom: 20px;
    }
    .btn-primary {
        background-color: #018abd;
        border-color: #018abd;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #016a95;
    }
    .container-fluid {
        margin-top: 50px;
        padding: 30px;
        background-color: #f7f9fc;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .alert-danger {
        color: #fff;
        background-color: #e74c3c;
        border-color: #e74c3c;
    }
    input::placeholder {
        color: #888;
    }
</style>

<div class="container-fluid"> 
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Registro de Usuarios</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese su nombre completo" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme su contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </form>
        </div>
    </div>
</div>
@endsection
