<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\Voucher;

class PlinVoucherController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'voucher_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Guarda la imagen
        $image = $request->file('voucher_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/vouchers', $imageName);

        $fullImagePath = storage_path('app/public/vouchers/' . $imageName);

        if (!file_exists($fullImagePath)) {
            return "Error: Imagen no encontrada en la ruta: " . $fullImagePath;
        }

        // Procesar la imagen con OCR
        $ocr = new TesseractOCR($fullImagePath);
        $text = $ocr->run();

        // Extraer datos
        $fecha = $this->Fecha($text);
        $operacion = $this->operacion($text);
        $monto = $this->Monto($text);
        $hora = $this->hora($text);

        // Pasar los datos a una vista previa para confirmar
        return view('voucher.Plinresul', compact('fecha', 'operacion', 'monto', 'hora', 'imageName'));
    }


    public function confirm(Request $request)
    {
       
    
        $voucher = new Voucher();
        $voucher->fecha = $request->input('fecha');
        $voucher->hora = $request->input('hora');
        $voucher->operacion = $request->input('operacion');
        $voucher->monto = $this->processMonto($request->input('monto'));
        $voucher->codigo_dni = $request->input('codigo_dni');
        $voucher->servicio = $request->input('servicio');
    
        $voucher->save();
    
        return redirect()->route('voucher.success')->with('success', 'Voucher guardado correctamente');
    }



    private function processMonto($montoStr)
    {
        // Eliminar el símbolo de moneda y espacios
        $montoStr = preg_replace('/[^0-9.]/', '', $montoStr);
        
        // Convertir a float
        return floatval($montoStr);
    }

    private function Fecha($text)
    {
        preg_match('/\d{2} \w+ \d{4}/', $text, $matches);
        return $matches[0] ?? 'No encontrado';
    }

    private function hora($text)
    {
        preg_match('/\d{2}:\d{2} [APM]{2}/i', $text, $matches);
        return $matches[0] ?? 'No encontrado';
    }

    private function operacion($text)
    {
        preg_match_all('/\b\d{8}\b/', $text, $matches);
        return $matches[0][0] ?? 'No encontrado';
    }

    private function Monto($text)
    {
        preg_match('/S\/\s?\d+(?:\.\d{2})?/', $text, $matches);
        return $matches[0] ?? 'No encontrado';
    }

  
}
