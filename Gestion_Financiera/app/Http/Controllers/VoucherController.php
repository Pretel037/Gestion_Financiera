<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Carbon\Carbon;
use App\Models\Course;
class VoucherController extends Controller
{
    public function process(Request $request)
{
    $request->validate([
        'voucher_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Guarda la imagen con un nombre basado en el tiempo y el nombre original
    $image = $request->file('voucher_image');
    $imageName = time() . '_' . $image->getClientOriginalName();
    $image->storeAs('public/vouchers', $imageName);

    // Ruta completa de la imagen
    $fullImagePath = storage_path('app/public/vouchers/' . $imageName);

    if (!file_exists($fullImagePath)) {
        return "Error: Imagen no encontrada en la ruta: " . $fullImagePath;
    }

    try {
        $ocr = new TesseractOCR($fullImagePath);
        $text = $ocr->run();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al procesar la imagen. Por favor, sube una imagen válida.');
    }

    // Validar que la imagen tenga contenido esperado
    if (!$this->isVoucherContentValid($text)) {
        return back()->withErrors(['voucher_image' => 'La imagen no contiene un voucher válido.']);
    }

    // Nuevas extracciones
    $operacion = $this->extractSequence($text);
    $fecha = $this->extractAndConvertOperationDate($text);
    $hora = $this->extractOperationTime($text);
    $monto = $this->extractTotalAmount($text);
    $courses = Course::all();

    return view('voucher.result', compact('operacion', 'fecha', 'hora', 'monto', 'courses'));
}

private function isVoucherContentValid($text)
{
    // Verifica si el texto extraído tiene elementos específicos de un voucher válido
    return preg_match('/IMPORTE TOTAL:/', $text) && preg_match('/\d{6}/', $text);
}

    public function confirm(Request $request)
    {
        // Guardar los datos en la base de datos después de la confirmación
        $voucher = new Voucher();
        $voucher->hora = $request->input('hora');
        $voucher->operacion = $request->input('oper acion');
        
        // Procesar el monto correctamente
        $montoStr = $request->input('monto');
        $monto = $this->processMonto($montoStr);
        $voucher->monto = $monto;

        $voucher->codigo_dni = $request->input('codigo_dni');
        $voucher->servicio = $request->input('servicio');
        $voucher->fecha = $request->input('fecha');
        $voucher->save();

        return redirect()->route('voucher.success')->with('success', 'Voucher guardado correctamente');
    }
    private function processMonto($montoStr)
    {
        $montoStr = preg_replace('/[^0-9.]/', '', $montoStr);
        return floatval($montoStr);
    }

    private function extractAndConvertOperationDate($text)
    {
        
        if (preg_match('/(\d{2}[A-Z]{3}\d{4})/', $text, $matches)) {
            $fechaStr = $matches[1];
            
            // Mapeo de abreviaturas de meses en español a números
            $meses = [
                'ENE' => '01', 'FEB' => '02', 'MAR' => '03', 'ABR' => '04',
                'MAY' => '05', 'JUN' => '06', 'JUL' => '07', 'AGO' => '08',
                'SEP' => '09', 'OCT' => '10', 'NOV' => '11', 'DIC' => '12'
            ];
    
            // Convierte la fecha extraída a formato YYYY-MM-DD
            if (preg_match('/(\d{2})([A-Z]{3})(\d{4})/', $fechaStr, $fechaMatches)) {
                $dia = $fechaMatches[1];
                $mes = $meses[$fechaMatches[2]] ?? null;
                $anio = $fechaMatches[3];
    
                if ($mes) {
                    // Retorna la fecha en el formato Y-m-d (YYYY-MM-DD)
                    return Carbon::createFromFormat('Y-m-d', "$anio-$mes-$dia")->format('Y-m-d');
                }
            }
        }
    
        return 'No encontrado'; // Retorna 'No encontrado' si no se puede extraer o convertir la fecha
    }

    
    private function extractSequence($text)
    {
        preg_match('/(\d{6})\s*-/', $text, $matches);
    
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractOperationDate($text)
    {
        preg_match('/(\d{2}[A-Z]{3}\d{4})/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    

    private function extractOperationTime($text)
    {
        preg_match('/(\d{2}:\d{2}:\d{2})/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }


    private function extractTotalAmount($text)
    {
      
    preg_match('/.*IMPORTE TOTAL:.*?(\d+(?:\.\d{2})?)/', $text, $matches);
    return $matches[1] ?? 'No encontrado';
   
    }


/*

   //$documentType = $this->extractDocumentType($text);
    //$code = $this->extractCode($text);
   // $name = $this->extractName($text);
   
    //$TICKET = $this->TICKET($text);
    //$CONCEPTO = $this->CONCEPTO($text);
    

    <p><strong>Número de operación:</strong> {{ $sequence }}</p>
    <p><strong>Número de Ticket:</strong> {{ $TICKET }}</p>
    <p><strong>Concepto de Pago:</strong> {{ $CONCEPTO }}</p>
    <p><strong>Nombre:</strong> {{ $name }}</p>
    <p><strong>Código:</strong> {{ $code }}</p>
    <p><strong>Tipo de Documento:</strong> {{ $documentType }}</p>




    private function extractDocumentType($text)
    {
        preg_match('/TIPO DE DOCUMENTO:\s*(.+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    private function extractCode($text)
    {
        preg_match('/CODIGO:\s*(\d+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    

    private function extractName($text)
    {
        preg_match('/NOMBRE:\s*(.+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }


     
    private function CONCEPTO($text)
    {
        preg_match('/CONCEPTO DE PAGO:\s*(.+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }

    private function TICKET($text)
    {
        preg_match('/NRO. TICKET:\s*(\d+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    
    */
    

    
    


}