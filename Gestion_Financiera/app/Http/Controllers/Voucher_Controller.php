<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\PagosSiggass;
use App\Models\VoucherValidado;
use DB;

class Voucher_Controller extends Controller
{
    // Muestra la vista principal con los datos de ambas tablas
    public function index()
    {
         // Obtener los números de operación que ya han sido validados
         $validados = VoucherValidado::pluck('numero_operacion')->toArray();

         // Obtener todos los datos de pagos_sigga que no han sido validados
         $pagosSigga = PagosSiggass::whereNotIn('numero_operacion', $validados)->get();
 
         // Obtener solo los vouchers que corresponden a los pagosSigga no validados
         $vouchers = Voucher::whereIn('operacion', $pagosSigga->pluck('numero_operacion'))->get();
 
         return view('validaciones.index', compact('pagosSigga', 'vouchers'));
    }

    // Buscar el voucher que coincida con el numero_operacion
    public function buscarVoucher(Request $request)
    {
        $voucher = Voucher::where('operacion', $request->numero_operacion)
                             ->where('monto', $request->monto)
                             ->where('fecha', $request->fecha_pago)
                             ->first();
    
        if ($voucher) {
            // Obtener el pago correspondiente aquí
            $pagoSigga = PagosSiggass::where('numero_operacion', $voucher->operacion)->first(); // O cualquier otra relación
    
            return response()->json([
                'success' => true,
                'voucher' => view('validaciones.partials.voucher_row', compact('voucher', 'pagoSigga'))->render(),
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'No se encontró un voucher que coincida.']);
        }
    }
    


    public function validarVoucher(Request $request) { 
        // Validar los datos de entrada
        $request->validate([
            'voucher_id' => 'required|exists:vouchers,id',
            'pagos_siga_id' => 'required|exists:pagos_s_i_g_g_a_s,id',
        ]);
    
        try {
            DB::beginTransaction();
    
            // Obtener datos de Voucher
            $voucher = Voucher::findOrFail($request->voucher_id);
    
            // Obtener datos de PagosSiggass
            $pagoSigga = PagosSiggass::findOrFail($request->pagos_siga_id);
    
            // Verificar si ya existe un registro con el mismo número de operación
            $existe = VoucherValidado::where('numero_operacion', $pagoSigga->numero_operacion)->exists();
    
            if ($existe) {
                return response()->json(['success' => false, 'message' => 'El número de operación ya ha sido validado.'], 400);
            }
    
            // Crear nuevo VoucherValidado
            $voucherValidado = new VoucherValidado();
            $voucherValidado->voucher_id = $voucher->id;
            $voucherValidado->pagos_siga_id = $pagoSigga->id;
            $voucherValidado->numero_operacion = $pagoSigga->numero_operacion;
            $voucherValidado->fecha_pago = $pagoSigga->fecha_pago;
            $voucherValidado->monto = $pagoSigga->monto_pago;
            $voucherValidado->dni_codigo = $voucher->codigo_dni;
            $voucherValidado->nombres = $pagoSigga->nombres;
            $voucherValidado->apellidos = $pagoSigga->apellidos;
            $voucherValidado->nombre_curso_servicio = $voucher->servicio;
            $voucherValidado->estado = 1;
            $voucherValidado->save();
    
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Voucher validado e insertado correctamente.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error al validar el voucher: ' . $e->getMessage()], 500);
        }
    }
}