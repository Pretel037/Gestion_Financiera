<!DOCTYPE html>
<html>
<head>
    <title>Integración de Culqui</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://checkout.culqi.com/js/v4"></script>
    <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #2d3436;
        }

        .payment-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .payment-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .payment-header h2 {
            color: #2d3436;
            font-weight: 600;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 500;
            color: #2d3436;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            height: auto;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4834d4;
            box-shadow: 0 0 0 0.2rem rgba(72, 52, 212, 0.15);
        }

        .price-display {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 0;
            border: 2px solid #e9ecef;
        }

        .price-display label {
            display: block;
            margin-bottom: 10px;
            color: #2d3436;
            font-weight: 600;
        }

        #totalPrice {
            font-size: 24px;
            color: #4834d4;
            font-weight: 700;
            margin: 0;
        }

        .button-container {
            text-align: center;
            margin-top: 30px;
        }

        .btn-proceed-checkout {
            background-color: #4834d4;
            color: white;
            padding: 15px 40px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 400px;
        }

        .btn-proceed-checkout:hover:not(:disabled) {
            background-color: #3c28b8;
            transform: translateY(-2px);
        }

        .btn-proceed-checkout:disabled {
            background-color: #b2bec3;
            cursor: not-allowed;
        }

        .btn-back {
            display: inline-block;
            color: #636e72;
            text-decoration: none;
            margin-top: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            color: #2d3436;
            text-decoration: none;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-col {
            flex: 1;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .payment-container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <h2>Pago de Certificado</h2>
        </div>

        <form id="paymentForm">
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="firstName">Nombres</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="firstName" 
                            required 
                            maxlength="15" 
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
                            inputmode="text"
                            title="Solo se permiten letras y un máximo de 15 caracteres."
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                        >
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="lastName">Apellidos</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="lastName" 
                            required 
                            maxlength="15" 
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
                            inputmode="text" 
                            title="Solo se permiten letras y un máximo de 15 caracteres."
                            oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                        >
                    </div>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="dni_comp">DNI</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="dni_comp" 
                            name="dni_comp" 
                            required 
                            maxlength="8" 
                            pattern="\d{8}" 
                            inputmode="numeric" 
                            title="Debe contener exactamente 8 dígitos numéricos."
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label for="correo_comp">Correo Electrónico</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="correo_comp" 
                            name="correo_comp" 
                            required 
                            maxlength="50"
                            title="El correo no debe exceder 50 caracteres."
                        >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="course">Certificado</label>
                <select class="form-control" id="course" required>
                    <option value="">Selecciona el tipo de Certificado</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" data-precio="{{ $course->precio }}">
                            {{ $course->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="price-display">
                <label>Precio a Pagar</label>
                <p id="totalPrice">S/. {{ $totCart}}</p>
            </div>

            <div class="button-container">
                <button type="submit" class="btn-proceed-checkout" id="buyButton" name="prePago" title="Procesar con el Pago" disabled>
                    <span>Procesar con el Pago</span>
                </button>
                <div>
                    <a href="{{ route('inicio') }}" class="btn-back">Volver a la Página Inicial</a>
                </div>
            </div>
        </form>
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