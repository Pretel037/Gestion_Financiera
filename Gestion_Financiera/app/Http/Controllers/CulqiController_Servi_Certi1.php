<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Culqi\Culqi;
use App\Models\VoucherValidado;
use App\Models\Course; 
use App\Models\Certificado; 


class CulqiController_Servi_Certi1 extends Controller
{
    private $culqi;

    public function __construct()
    {
        $this->culqi = new Culqi(['api_key' => env('CULQI_SECRET_KEY')]);
    }

    public function showPaymentForm(Request $request)
    {
        //certificado
        $courses = Certificado::all(); 
        $totCart =10000;

         // Obtener el DNI y correo del request, o asignar un valor predeterminado si no están presentes
        $dni_comp = $request->input('dni_comp', '72535264');
        $correo_comp = $request->input('correo_comp', 'admin@.com');

    
        $data = [
            'sid' => session()->getId(),
            'totCart' => $totCart,
            'dni_comp' => $dni_comp,
            'direccion' => 'Nuevo Chimbote',
            'departamento' => 'Ancash',
            'provincia' => 'Ancash',
            'nombre_comp' => 'Sistema Sigga',
            'correo_comp' => $correo_comp,
            'courses' => $courses
        ];

        return view('payment-form-certi-matri1', $data);
    }

    public function processPayment(Request $request)
    {
        try {
            // Log de los datos recibidos (sin información sensible)
            \Log::info('Datos recibidos:', [
                'amount' => $request->precio,
                'description' => $request->producto,
                'customer_id' => $request->customer_id,
                'first_name' => $request->first_name
            ]);

            // Validar los datos recibidos
            $request->validate([
                'precio' => 'required|numeric',
                'token' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'dni' => 'required',
                'curso' => 'required',
                'course_id' => 'required|exists:courses,id'
            ]);
    
            // Preparar los datos para Culqi
            $chargeData = [
                "amount" => $request->precio,
                "capture" => true,
                "currency_code" => "PEN",
                "description" => $request->producto,
                "email" => $request->email ?? '',  // Asegúrate de que tienes el email
                "source_id" => $request->token
            ];

            // Log de los datos que se enviarán a Culqi
            \Log::info('Datos enviados a Culqi:', $chargeData);
    
            // Procesar el pago con Culqi
            try {
                $charge = $this->culqi->Charges->create($chargeData);
                \Log::info('Respuesta completa de Culqi:', ['charge' => $charge]);
            } catch (\Culqi\Error\UnhandledException $e) {
                \Log::error('Error de Culqi (Unhandled):', [
                    'message' => $e->getMessage(),
                    'type' => get_class($e)
                ]);
                throw $e;
            } catch (\Culqi\Error\InvalidApiKey $e) {
                \Log::error('Error de Culqi (Invalid API Key):', [
                    'message' => $e->getMessage()
                ]);
                throw $e;
            } catch (\Exception $e) {
                \Log::error('Error general de Culqi:', [
                    'message' => $e->getMessage(),
                    'type' => get_class($e)
                ]);
                throw $e;
            }
            
            // Verificar si tenemos una respuesta válida
            if (empty($charge)) {
                throw new \Exception('No se recibió respuesta de Culqi');
            }
            
        
    
            // Guardar en la base de datos
            $voucherValidado = new VoucherValidado();
            $voucherValidado->nombres = $request->first_name;
            $voucherValidado->apellidos = $request->last_name;
            $voucherValidado->dni_codigo = $request->dni;
            $voucherValidado->fecha_pago = now();
            $voucherValidado->monto = $request->precio / 100; 
            $voucherValidado->nombre_curso_servicio = $request->curso;
            $voucherValidado->estado = 1;
          $voucherValidado->numero_operacion = now()->format('dmYHis'); 

    
            if (!$voucherValidado->save()) {
                \Log::error('Error al guardar el voucher:', ['voucher' => $voucherValidado]);
                throw new \Exception('Error al guardar el voucher');
            }
            return response()->json([
                'status' => 'success', 
                'message' => 'Pago realizado con éxito',
                'voucher_id' => $voucherValidado->id,
 
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en el proceso de pago:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error', 
                'message' => 'Error en el proceso de pago: ' . $e->getMessage()
            ], 400);
        }
    }
}