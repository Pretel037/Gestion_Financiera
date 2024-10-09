<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

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
    $operacion = $this->extractSequence($text);
    $fecha = $this->extractOperationDate($text);
    $hora = $this->extractOperationTime($text);
    $monto = $this->extractTotalAmount($text);
 

    // Pasar todos los datos a la vista
    return view('voucher.result', compact(
        'operacion', 'fecha',
         'hora', 'monto',
    ));
    }

    public function confirm(Request $request)
    {
        // Guardar los datos en la base de datos después de la confirmación
        $voucher = new Voucher();
        $voucher->fecha = $request->input('fecha');
        $voucher->hora = $request->input('hora');
        $voucher->operacion = $request->input('operacion');
        
        // Procesar el monto correctamente
        $montoStr = $request->input('monto');
        $monto = $this->processMonto($montoStr);
        $voucher->monto = $monto;
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