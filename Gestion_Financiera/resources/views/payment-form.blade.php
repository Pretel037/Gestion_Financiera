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
    <div class="container mt-5">
        <h2>Formulario de Pago</h2>
        <form id="paymentForm">
            <div class="form-group">
                <label for="firstName">Nombres</label>
                <input type="text" class="form-control" id="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Apellidos</label>
                <input type="text" class="form-control" id="lastName" required>
            </div>
            <div class="form-group">
                <label for="dni_comp">DNI</label>
                <input type="text" class="form-control" id="dni_comp" name="dni_comp" required>
            </div>
            <div class="form-group">
                <label for="correo_comp">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo_comp" name="correo_comp" required>
            </div>
            

            <div class="form-group">
                <label for="course">Curso</label>
                <select class="form-control" id="course" required>
                    <option value="">Selecciona un curso</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" data-precio="{{ $course->precio }}">
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Precio a Pagar</label>
                <p id="totalPrice">S/. {{ $totCart}}</p>
                
            </div>
            <button type="submit" class="button btn-proceed-checkout" id="buyButton" name="prePago" title="Procesar con el Pago" disabled>
                <span>Procesar con el Pago</span>
            </button>
        </form>
        <a href="{{ route('inicio') }}" class="btn btn-secondary mt-3">Volver a la Página Inicial</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    
    <script>
        
        Culqi.publicKey = '{{ env('CULQI_PUBLIC_KEY') }}';

        var totalPago = '{{ $totCart }}';

        Culqi.settings({
            title: 'SISTEMA DE GESTION FINANCIERA',
            currency: 'PEN',
            description: 'SIGF - UNS',
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

       // Actualizar la validación del botón
function toggleBuyButton() {
    const firstName = $('#firstName').val().trim();
    const lastName = $('#lastName').val().trim();
    const course = $('#course').val().trim();
    const dni = $('#dni_comp').val().trim();
    const email = $('#correo_comp').val().trim();

    // Habilitar el botón solo si todos los campos están llenos
    $('#buyButton').prop('disabled', !(firstName && lastName && course && dni && email));
}

        // Evento para verificar los campos al escribir
        $('#firstName, #lastName, #course').on('input', toggleBuyButton);


        // Evento para abrir el modal de pago
        $('#buyButton').on('click', function(e) {
            Culqi.open();
            e.preventDefault();
        });


        /////


        $('#course').on('change', function() {
    // Obtener el precio del curso seleccionado
    var precioCurso = $(this).find(':selected').data('precio');
    
    // Actualizar el precio total
    $('#totalPrice').text('S/. ' + parseFloat(precioCurso).toFixed(2)); // Actualizar el precio mostrado
    totalPago = precioCurso * 100; // Actualiza totalPago para el proceso de pago
});




        // Ajax para el proceso de pago
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        function culqi() {
    if (Culqi.token) {
        var token = Culqi.token.id;
        var email = Culqi.token.email;
        
        // Obtener el curso seleccionado
        var cursoSeleccionado = $('#course option:selected');
        var nombreCurso = cursoSeleccionado.text();

        var data = {
            id: '{{ $sid }}',
            producto: nombreCurso,
            precio: totalPago,
            token: token,
            customer_id: $('#dni_comp').val() + '_' + '{{ $sid }}',
            address: "{{ $direccion }}",
            address_city: "{{ $departamento . ' - ' . $provincia }}",
            first_name: $('#firstName').val(),
            last_name: $('#lastName').val(),
            email: $('#correo_comp').val(),
            course_id: $('#course').val(),
            dni: $('#dni_comp').val(),
            curso: nombreCurso
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