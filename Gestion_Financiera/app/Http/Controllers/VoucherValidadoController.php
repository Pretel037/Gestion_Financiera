<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherValidado;

class VoucherValidadoController extends Controller
{
    public function index()
    {
        $vouchers = VoucherValidado::all(); // Retrieve all vouchers+
        return view('vouchers_validados', compact('vouchers')); // Pass data to the view
    }
}
