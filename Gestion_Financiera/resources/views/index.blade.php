<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Licorera ACME')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body, html { 
            margin: 0; 
            padding: 0; 
            font-family: Arial, sans-serif; 
            height: 100%; 
            overflow: hidden; 
        }
        .container { 
            display: flex; 
            height: 100vh; 
        }
        .sidebar { 
            width: 250px; 
            background-color: #2a00faef; 
            color: white; 
            padding-top: 20px; 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            top: 0;
            left: 0;
            height: 100vh; 
            z-index: 1000; 
        }
        .sidebar-header { 
            padding: 20px; 
            border-bottom: 1px solid #2a00fa; 
        }
        .sidebar-header img { 
            width: 50px; 
            height: 50px; 
            border-radius: 50%; 
        }
        .sidebar-menu { 
            padding: 0; 
            list-style-type: none; 
            flex-grow: 1; 
        }
        .sidebar-menu li a { 
            display: block; 
            color: white; 
            padding: 15px 20px; 
            text-decoration: none; 
        }
        .sidebar-menu li a:hover { 
            background-color: #34495e; 
        }
        .main-content {
            margin-left: 250px; 
            background-color: #ecf0f1; 
            width: calc(100% - 250px); 
            height: 100vh; 
            overflow-y: auto; 
        }

        .content {
            padding: 20px; 
            background-color: white; 
            height: calc(100vh - 80px); 
            overflow-y: auto; 
        }
    </style>
    
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <img src="https://via.placeholder.com/50" alt="User Avatar">
                <p>Gestor</p>
                <small>Online</small>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('import') }}"><i class="fas fa-home mr-2"></i>INICIO</a></li>
                <li><a href="{{ route('registro') }}"><i class="fas fa-users mr-2"></i>USUARIOS</a></li>
                <li><a href="{{ route('import') }}"><i class="fas fa-book mr-2"></i>CURSOS</a></li>
                <li><a href="{{ route('vouchers') }}"><i class="fas fa-chart-bar mr-2"></i>VOUCHERS VALIDADOS</a></li>
                <li><a href="{{ route('mostrarReporte') }}"><i class="fas fa-chart-bar mr-2"></i>REPORTES</a></li>
                
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i>CERRAR SESIÓN
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
