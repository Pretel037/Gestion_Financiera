<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Voucher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <p><strong>Fecha de Pago:</strong> {{ $fecha }}</p>
                        <p><strong>Hora de Pago:</strong> {{ $hora }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Número de Operación:</strong> {{ $operacion }}</p>
                        <p><strong>Monto:</strong> {{ $monto }}</p>
                    </div>
                </div>
                <form action="{{ route('voucher.confirm') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="codigo_dni" class="form-label">Código/DNI</label>
                        <input 
                            type="text" 
                            name="codigo_dni" 
                            id="codigo_dni" 
                            class="form-control" 
                            required 
                            pattern="\d{8}" 
                            inputmode="numeric" 
                            title="El código/DNI debe tener exactamente 8 dígitos numéricos."
                        >
                    </div>

                    <div class="mb-3">
                        <label for="servicio" class="form-label">Curso</label>
                        <select name="servicio" id="servicio" class="form-control" required>
                            <option value="">Selecciona un curso</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->name }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="fecha" value="{{ $fecha }}">
                    <input type="hidden" name="hora" value="{{ $hora }}">
                    <input type="hidden" name="operacion" value="{{ $operacion }}">
                    <input type="hidden" name="monto" value="{{ $monto }}">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success me-md-2">Confirmar y Guardar</button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}"

            });
        @endif
    });
    </script>