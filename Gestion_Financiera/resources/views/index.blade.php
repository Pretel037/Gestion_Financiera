<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GESTION FINANCIERA')</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <style>



html,body { 
            margin: 0; 
            padding: 0; 
            font-family: 'Montserrat', sans-serif; 
            font-size: 14px;
            line-height: 1.6;
            height: 100%; 
            width: 100%;
            overflow: hidden; 
        }
    
        .container { 
            display: flex; 
            height: 100vh; 
        }
    
        .sidebar { 
            width: 220px; 
            background-color: #003d73; 
            color: white; 
            padding-top: 20px; 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            top: 0;
            left: 0;
            height: 100vh; 
            z-index: 1000; 
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }
    
        .sidebar-header {
            padding: 20px;
            border-bottom: 5px solid #2a00fa;
            text-align: center; 
        }
    
        .sidebar-header img { 
            width: 100px; 
            height: 100px; 
            border-radius: 50%; 
        }
    
        .sidebar-header p {
            font-size: 18px;
            font-weight: 600;
        }
    
        .sidebar-menu { 
            padding: 0; 
            list-style-type: none; 
            flex-grow: 1; 
        }
    
        .sidebar-menu li { 
            position: relative; 
        }
    
        .sidebar-menu li a { 
            display: flex; 
            align-items: center;
            color: white; 
            padding: 15px 30px; 
            text-decoration: none;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
        }
    
        .sidebar-menu li a:hover { 
            background-color: #026699;
            padding-left: 40px;
        }
    
        .sidebar-menu li a i {
            margin-right: 8px;
        }
    
        .sub-menu {
            display: none;
            list-style: none;
            padding-left: 20px;
        }
    
        .sub-menu li a {
            padding: 10px 20px;
        }
    
        .sidebar-menu li:hover .sub-menu {
            display: block;
        }
    
        .main-content {
    margin-left: 220px; /* Espacio reservado para el menú lateral */
    background-color: #ffffff;
    width: calc(100% - 150px); /* Ocupa el resto del ancho */
    height: 100vh; /* Ocupa toda la altura de la pantalla */
    display: flex;

    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.content {
    background-color: white;
    flex-grow: 1; /* Se expande para ocupar todo el espacio disponible */
    width: 100%; /* Ocupa todo el ancho */
    height: 100%; /* Asegura que el contenido ocupe toda la altura disponible */
    /* Permite scroll vertical si es necesario */
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}


    
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
    
            .main-content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
        }
    
        @media (max-width: 480px) {
            .sidebar {
                width: 100px;
            }
    
            .main-content {
                margin-left: 100px;
                width: calc(100% - 100px);
            }
    
            .sidebar-menu li a {
                padding: 10px 20px;
                font-size: 14px;
            }
    
            .sidebar-menu li a:hover {
                padding-left: 30px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <nav class="sidebar">
            <div class="sidebar-header">
                <img src="https://cdn-icons-png.flaticon.com/512/9187/9187604.png" alt="User Avatar">
                <p>Gestor</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('import') }}"><i class="fas fa-home"></i> INICIO</a></li>

          
                <li>
                    <a href="#"><i class="fas fa-file-invoice-dollar"></i> VOUCHERS <i class="fas fa-chevron-down" style="margin-left:auto;"></i></a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('registro') }}"><i class="fas fa-users"></i> VOUCHERS REGISTRADOS</a></li>
                        <li><a href="{{ route('import') }}"><i class="fas fa-book"></i> VOUCHERS SIGGA</a></li>
                        <li><a href="{{ route('vouchers') }}"><i class="fas fa-check"></i> VOUCHERS VALIDADOS</a></li>
                        <li><a href="{{ route('validaciones.index') }}"><i class="fas fa-users"></i> VALIDAR VOUCHERS</a></li>
                    </ul>
                </li>


                <li>
                    <a href="#"><i class="fas fa-chart-bar"></i> REPORTES <i class="fas fa-chevron-down" style="margin-left:auto;"></i></a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('mostrarReporte') }}"><i class="fas fa-chart-bar"></i> REPORTE GENERAL</a></li>
                        <li><a href="{{ route('reportes.obtenerPagos') }}"><i class="fas fa-file-alt"></i> REPORTE FINANCIERO CURSOS</a></li>
                        <li><a href="{{ route('reportes.obtenerPagos1') }}"><i class="fas fa-file-alt"></i> REPORTE FINANCIERO CERTIFICADOS</a></li>
                    
                    </ul>
                </li>

                <li><a href="{{ route('register') }}"><i class="fas fa-users"></i> CREAR USUARIOS</a></li>

                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>CERRAR SESIÓN
                    </a>
                </li>
            </ul>
        </nav>

        <div class="main-content">
    
                @yield('content')
      
        </div>
    </div>

    <div>
        <h1>Bienvenido al SGF</h1>
    </div>

</body>
</html>
