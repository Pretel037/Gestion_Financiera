<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\Voucher;
use Carbon\Carbon;
use App\Http\Controllers\DateTime;

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
        $fecha = $this->extractAndConvertOperationDate($text);
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



    private function extractAndConvertOperationDate($text)
    {
        
        if (preg_match('/(\d{2}) (\w{3}) (\d{4})/', $text, $matches)) {
            $dia = $matches[1];
            $mesAbreviado = $matches[2];
            $anio = $matches[3];
    
            // Mapeo de abreviaturas de meses en español a números
            $meses = [
                'Ene' => '01', 'Feb' => '02', 'Mar' => '03', 'Abr' => '04',
                'May' => '05', 'Jun' => '06', 'Jul' => '07', 'Ago' => '08',
                'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dic' => '12'
            ];
    
            if (isset($meses[$mesAbreviado])) {
                $mes = $meses[$mesAbreviado];
                // Retorna la fecha en el formato Y-m-d (YYYY-MM-DD)
                return Carbon::createFromFormat('Y-m-d', "$anio-$mes-$dia")->format('Y-m-d');
            }
        }
    
        return 'No encontrado'; // Retorna 'No encontrado' si no se puede extraer o convertir la fecha
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
    // Extrae la hora con AM o PM
    if (preg_match('/\d{2}:\d{2} [APM]{2}/i', $text, $matches)) {
        $horaStr = $matches[0];

        // Convierte la hora de 12 horas (AM/PM) a 24 horas
        $dateTime = \DateTime::createFromFormat('h:i A', $horaStr);
        
        if ($dateTime) {
            // Devuelve la hora en formato de 24 horas (HH:mm)
            return $dateTime->format('H:i');
        }
    }

   
    return 'No encontrado';
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
