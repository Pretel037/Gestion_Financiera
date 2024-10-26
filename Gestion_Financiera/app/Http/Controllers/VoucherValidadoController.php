<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherValidado;

class VoucherValidadoController extends Controller
{
    public function index(Request $request)
    {
        // Inicializa la consulta
        $query = VoucherValidado::query();

        // Recoge los parámetros de búsqueda
        $numeroOperacion = $request->input('numero_operacion');
        $codigoDNI = $request->input('codigo_dni');
        $fechaPago = $request->input('fecha_pago');

        // Aplica los filtros según la búsqueda
        if ($numeroOperacion) {
            $query->where('numero_operacion', 'like', '%' . $numeroOperacion . '%');
        }

        if ($codigoDNI) {
            $query->where('dni_codigo', 'like', '%' . $codigoDNI . '%');
        }

        if ($fechaPago) {
            $query->whereDate('fecha_pago', $fechaPago);
        }

        // Obtiene los vouchers filtrados
        $vouchers = $query->get();

        return view('vouchers_validados', compact('vouchers', 'numeroOperacion', 'codigoDNI', 'fechaPago'));
    }
}
