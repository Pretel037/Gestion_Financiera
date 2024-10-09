<!-- resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="flex">
        <!-- Menú lateral -->
        <nav class="w-64 bg-red-600 text-white min-h-screen">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-4">MENÚ</h2>
                <div class="mb-4">
                    <i class="fas fa-user-circle text-4xl"></i>
                    <p>ADMIN USER</p>
                </div>
                
                <ul>
                    <li><a href="{{ route('registro') }}" class="block py-2"><i class="fas fa-home mr-2"></i>INICIO</a></li>
                    <li><a href="{{ route('registro') }}" class="block py-2"><i class="fas fa-users mr-2"></i>USUARIOS</a></li>
                    <li><a href="{{ route('payment.form') }}" class="block py-2"><i class="fas fa-book mr-2"></i>CURSOS</a></li>
                    <li><a href="{{ route('import') }}" class="block py-2"><i class="fas fa-chart-bar mr-2"></i>REPORTES</a></li>
                  </ul>
                </div>
            </nav>
    
            <!-- Contenido principal -->
            <main class="flex-1 p-8">
                @yield('content') <!-- Aquí se cargará el contenido dinámico -->
            </main>
        </div>
    
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
    </html>