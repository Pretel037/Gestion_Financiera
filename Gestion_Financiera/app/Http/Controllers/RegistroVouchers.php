<?php
namespace App\Http\Controllers;

use App\Models\Voucher;  // Asegúrate de importar el modelo Voucher
use Illuminate\Http\Request;

class RegistroVouchers extends Controller
{
    public function index(Request $request)
    {
        // Inicializa las variables de búsqueda
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $numeroOperacion = $request->input('numero_operacion');
        $codigoDNI = $request->input('codigo_dni');
        $operacion = $request->input('operacion');

        // Construye la consulta
        $query = Voucher::query();

        // Filtra por fecha si se han proporcionado
        if ($startDate && $endDate) {
            $query->whereBetween('fecha', [$startDate, $endDate]);
        }

        // Filtra por número de operación si se ha proporcionado
        if ($numeroOperacion) {
            $query->where('operacion', 'like', '%' . $numeroOperacion . '%');
        }

        // Filtra por código DNI si se ha proporcionado
        if ($codigoDNI) {
            $query->where('codigo_dni', 'like', '%' . $codigoDNI . '%');
        }

        // Filtra por operación si se ha proporcionado
        if ($operacion) {
            $query->where('operacion', 'like', '%' . $operacion . '%');
        }

        // Obtiene los vouchers filtrados
        $vouchers = $query->get();

        return view('registro', compact('vouchers', 'startDate', 'endDate', 'numeroOperacion', 'codigoDNI', 'operacion'));
    }
}
