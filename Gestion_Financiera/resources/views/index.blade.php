<!DOCTYPE html>
<html>
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Integración de Culqi</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">

	<!-- Incluyendo Culqi Checkout -->
	<script type="text/javascript" src="https://checkout.culqi.com/js/v3"></script>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script&amp;subset=latin-ext" rel="stylesheet">
</head>
<body>

	<button type="submit" class="button btn-proceed-checkout" id="buyButton" title="Procesar con el Pago"><span>Procesar con el Pago</span></button>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>

  <script>
    Culqi.publicKey = 'pk_test_a688d55bdc888bdd';

    // Descomponer el total del carrito
    var totalPago = {{ $_SESSION['totCart'] ?? 1500 }};

    Culqi.settings({
      title: 'Tienda en Linea - Frank Moreno',
      currency: 'PEN',
      description: 'Pago Productos varios - Frank Moreno',
      amount: totalPago,
      metadata:{
        order_id: "{{ session()->getId() }}"
      }
    });

    $('#buyButton').on('click', function(e) {
        Culqi.open();
        e.preventDefault();
    });

    function pdf() {
      window.location.assign("/pagado");
    }

    function culqi() {
      if (Culqi.token) { 
        var token = Culqi.token.id;
        var email = Culqi.token.email;

        var data = { 
          id: "{{ session()->getId() }}", 
          producto: 'Productos varios. Frank Moreno', 
          precio: totalPago, 
          token: token, 
          customer_id: "{{ $dni_comp ?? '72042683' }}_{{ session()->getId() }}",
          address: "{{ $direccion ?? 'Francisco Lazo' }}",
          address_city: "{{ $departamento ?? 'Lima' }} - {{ $provincia ?? 'Lima' }}",
          first_name: "{{ $nombre_comp ?? 'Frank Moreno Alburqueque' }}",
          email: "{{ $correo_comp ?? 'admin@frankmorenoalburqueque.com' }}" 
        };

        
        $.post('/process-payment', data, function(res){
          alert('Tu pago se ha realizado con ' + res + '. Agradecemos tu preferencia.');
          if (res == "exito") {
            pdf();
          } else {
            alert("No se logró realizar el pago.");
          }
        });

      } else {
        console.log(Culqi.error);
        alert(Culqi.error.user_message);
      }
    };
  </script>
</body>
</html>
