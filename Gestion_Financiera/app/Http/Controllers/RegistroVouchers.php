<?php
namespace App\Http\Controllers;

use App\Models\Voucher;  // Asegúrate de importar el modelo Voucher
use Illuminate\Http\Request;

class RegistroVouchers extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla vouchers
        $vouchers = Voucher::all();
        
        // Pasar los registros a la vista
        return view('registro', compact('vouchers'));
    }
}
