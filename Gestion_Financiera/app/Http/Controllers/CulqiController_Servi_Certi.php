<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Culqi\Culqi;
use App\Models\VoucherValidado;
use App\Models\Course;
use App\Models\Matricula;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CulqiController_Servi_Certi extends Controller
{
    private $culqi;

    public function __construct()
    {
        $this->culqi = new Culqi(['api_key' => env('CULQI_SECRET_KEY')]);
    }

    public function showPaymentForm(Request $request)
    {
        $courses = Matricula::all();
        $totCart = 10000;
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

        return view('payment-form-certi-matri', $data);
    }

    public function processPayment(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validación inicial de los datos
            $validatedData = $request->validate([
                'precio' => 'required|numeric',
                'token' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'dni' => 'required',
                'curso' => 'required',
                'course_id' => 'required|exists:courses,id'
            ]);

            // Verificar si ya existe un pago para este DNI y curso
            $existingVoucher = VoucherValidado::where('dni_codigo', $request->dni)
                ->where('nombre_curso_servicio', $request->curso)
                ->first();

            if ($existingVoucher) {
                DB::rollBack();
                throw ValidationException::withMessages([
                    'dni' => ['Ya existe un pago registrado para este curso con el DNI proporcionado.']
                ]);
            }

            // Preparar datos para Culqi
            $chargeData = [
                "amount" => $request->precio,
                "capture" => true,
                "currency_code" => "PEN",
                "description" => $request->producto,
                "email" => $request->email ?? '',
                "source_id" => $request->token
            ];

            \Log::info('Iniciando pago con Culqi:', $chargeData);

            try {
                $charge = $this->culqi->Charges->create($chargeData);
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error en el pago con Culqi:', [
                    'message' => $e->getMessage(),
                    'type' => get_class($e)
                ]);
                throw new \Exception('Error al procesar el pago: ' . $e->getMessage());
            }

            // Verificar respuesta de Culqi
            if (empty($charge)) {
                DB::rollBack();
                throw new \Exception('No se recibió respuesta del procesador de pagos');
            }

            // Crear nuevo registro de voucher
            $voucherValidado = new VoucherValidado([
                'nombres' => $request->first_name,
                'apellidos' => $request->last_name,
                'dni_codigo' => $request->dni,
                'fecha_pago' => now(),
                'monto' => $request->precio / 100,
                'nombre_curso_servicio' => $request->curso,
                'estado' => 1,
                'numero_operacion' => now()->format('dmYHis')
            ]);

            if (!$voucherValidado->save()) {
                DB::rollBack();
                throw new \Exception('Error al guardar el registro del pago');
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pago realizado con éxito',
                'voucher_id' => $voucherValidado->id
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error en el proceso de pago:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error en el proceso de pago: ' . $e->getMessage()
            ], 500);
        }
    }
}