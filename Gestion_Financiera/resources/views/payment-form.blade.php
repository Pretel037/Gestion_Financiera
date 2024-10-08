<!DOCTYPE html>
<html>
<head>
    
    <title>Integración de Culqui</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://checkout.culqi.com/js/v4"></script>
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script&amp;subset=latin-ext" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <button type="submit" class="button btn-proceed-checkout" id="buyButton" name="prePago" title="Procesar con el Pago">
        <span>Procesar con el Pago</span>
    </button>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    
    <script>
        
        Culqi.publicKey = '{{ env('CULQI_PUBLIC_KEY') }}';

        var totalPago = '{{ $totCart }}';

        Culqi.settings({
            title: 'Tienda en Linea - Frank Moreno',
            currency: 'PEN',
            description: 'Pago Productos varios - Frank Moreno',
            amount: totalPago,
            metadata: {
                order_id: "{{ $sid }}"
            }
        });

        Culqi.options({
      style: {
        logo: 'https://culqi.com/LogoCulqi.png',
        bannerColor: '', // hexadecimal
        buttonBackground: '', // hexadecimal
        menuColor: '', // hexadecimal
        linksColor: '', // hexadecimal
        buttonText: '', // texto que tomará el botón
        buttonTextColor: '', // hexadecimal
        priceColor: '' // hexadecimal
      }
  });

        Culqi.options({
    lang: "auto",
    installments: false, // Habilitar o deshabilitar el campo de cuotas
    paymentMethods: {
      tarjeta: true,
      yape: true,
      bancaMovil: true,
      agente: true,
      billetera: true,
      cuotealo: true,
    },
    style: {
          logo: "https://static.culqi.com/v2/v2/static/img/logo.png",
    }
  });

        $('#buyButton').on('click', function(e) {
            Culqi.open();
            e.preventDefault();
        });
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

        function culqi() {
            if (Culqi.token) {
                var token = Culqi.token.id;
                var email = Culqi.token.email;

                var data = {
                    id: '{{ $sid }}',
                    producto: 'Productos varios. Frank Moreno',
                    precio: totalPago,
                    token: token,
                    customer_id: "{{ $dni_comp . '_' . $sid }}",
                    address: "{{ $direccion }}",
                    address_city: "{{ $departamento . ' - ' . $provincia }}",
                    first_name: "{{ $nombre_comp }}",
                    email: '{{ $correo_comp }}'
                };

                $.post("{{ route('process.payment') }}", data, function(res) {
                    if (res.status === "success") {
                        alert('Tu pago se Realizó con éxito. Agradecemos tu preferencia.');
                        window.location.assign("{{ route('payment.success') }}");
                    } else {
                        alert("No se logró realizar el pago: " + res.message);
                    }
                }).fail(function(xhr, status, error) {
                    alert("Error en el proceso de pago: " + error);
                });

            } else {
                console.log(Culqi.error);
                alert(Culqi.error.user_message);
            }
        }
    </script>
</body>
</html>