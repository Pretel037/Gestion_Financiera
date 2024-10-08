<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class YapeVoucherController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'voucher_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Guarda la imagen con un nombre basado en el tiempo y el nombre original
        $image = $request->file('voucher_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/vouchers', $imageName); // Asegúrate de que la ruta sea correcta
    
        // Asegúrate de que la ruta sea correcta
        $fullImagePath = storage_path('app/public/vouchers/' . $imageName);
    
        if (!file_exists($fullImagePath)) {
            return "Error: Imagen no encontrada en la ruta: " . $fullImagePath;
        }
    
        // Procesar la imagen con OCR
        $ocr = new TesseractOCR($fullImagePath);
      
        $text = $ocr->run();
    
        // Nuevas extracciones
        $Yapero = $this->Yapero($text);
        $Fecha = $this->Fecha($text);
        $operacion = $this->operacion($text);
        $Monto = $this->Monto($text);
        $hora = $this->hora($text);
        
    
        // Pasar todos los datos a la vista
        return view('voucher.yaperesul', compact('Yapero', 'Fecha', 'operacion', 'Monto','hora'));
    }
    
   /*
    private function Yapero($text)
    {
        preg_match('/Destinatario:\s*([^\\n]+)/i', $text, $matches);
    
        // Devolver el valor encontrado o "No encontrado" si no hay coincidencias
        return trim($matches[1] ?? 'No encontrado');
    }

*/


    
    private function Fecha($text)
{
    preg_match('/\d{2} \w+ \d{4}/', $text, $matches);
    return $matches[0] ?? 'No encontrado';  // Devuelve la fecha si la encuentra
}
private function hora($text) 
{
    // Expresión regular para la hora en formato: HH:MM AM/PM (ejemplo: 07:44 PM)
    preg_match('/\d{2}:\d{2} [APM]{2}/i', $text, $matches);
    return $matches[0] ?? 'No encontrado';  // Devuelve la hora si la encuentra
}
private function operacion($text)
{ preg_match_all('/\b\d{8}\b/', $text, $matches);
    return $matches[0][0] ?? 'No encontrado';
}

    



private function Monto($text)
{

preg_match('/S\/\s?\d+(?:\.\d{2})?/', $text, $matches);
return $matches[0] ?? 'No encontrado';  // Devuelve el monto si lo encuentra
}

    
}
