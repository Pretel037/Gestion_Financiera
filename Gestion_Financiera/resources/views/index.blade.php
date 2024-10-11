<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GESTION FINANCIERA')</title>
    
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
            background-color: #004581; 
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
    border-bottom: 5px solid #2a00fa;
    text-align: center; 
        .sidebar-header img { 
            width: 100px; 
            height: 100px; 
            border-radius: 50%; 
            align-self: center;
        }
        .sidebar-menu { 
            padding: 0; 
            list-style-type: none; 
            flex-grow: 1; 
        }
        .sidebar-menu li a { 
            display: block; 
            color: white; 
            padding: 15px 50px; 
            text-decoration: none; 
        }
        .sidebar-menu li a:hover { 
            background-color: #018abd; 
        }
        .main-content {
    margin-left: 140px; 
    background-color: #ffffff; 
    width: calc(100% - 140px); 
    height: calc(100%)
    overflow-y: auto;
}
.content {
    padding: 20px 20px 10px; 
    background-color: white; 
    height: calc(100vh - 80px); 
    overflow-y: auto;
    margin-bottom: 20px; 
}


    </style>
    
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <img src="https://cdn-icons-png.flaticon.com/512/9187/9187604.png" alt="User Avatar">
                <p>Gestor</p>
                <small>Online</small>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('import') }}"><i class="fas fa-home mr-4"></i>      INICIO</a></li>
                <li><a href="{{ route('registro') }}"><i class="fas fa-users mr-2"></i>      VOUCHERS REGISTRADOS</a></li>
                <li><a href="{{ route('import') }}"><i class="fas fa-book mr-2"></i>      VOUCHERS SIGGA</a></li>
                <li><a href="{{ route('vouchers') }}"><i class="fas fa-chart-bar mr-2"></i>      VOUCHERS VALIDADOS</a></li>
                <li><a href="{{ route('mostrarReporte') }}"><i class="fas fa-chart-bar mr-2"></i>      REPORTES</a></li>
                <li><a href="{{ route('register') }}"><i class="fas fa-users mr-2"></i>      CREAR USUARIOS</a></li>
                
                
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
