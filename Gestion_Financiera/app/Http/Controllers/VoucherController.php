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
    $sequence = $this->extractSequence($text);
    $operationDate = $this->extractOperationDate($text);
    $trx = $this->extractTrx($text);
    $cashierCode = $this->extractCashierCode($text);
    $officeCode = $this->extractOfficeCode($text);
    $operationTime = $this->extractOperationTime($text);

    $documentType = $this->extractDocumentType($text);
    $code = $this->extractCode($text);
    $name = $this->extractName($text);
    $totalAmount = $this->extractTotalAmount($text);
    $TICKET = $this->TICKET($text);
    $CONCEPTO = $this->CONCEPTO($text);
    

    // Pasar todos los datos a la vista
    return view('voucher.result', compact(
        'sequence', 'operationDate', 'trx',
        'cashierCode','CONCEPTO', 'officeCode','TICKET', 'operationTime','documentType', 'code', 'name', 'totalAmount',
    ));
    }
    
    private function extractSequence($text)
    {
        preg_match('/(\d{6}-\d)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractOperationDate($text)
    {
        preg_match('/(\d{2}[A-Z]{3}\d{4})/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractTrx($text)
    {
        preg_match('/(\d{4})(?=\s+\d{4}\s+\d{4})/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractCashierCode($text)
    {
        preg_match('/(\d{4})(?=\s+\d{4}\s+\d{2}:\d{2}:\d{2})/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractOfficeCode($text)
    {
        preg_match('/(\d{4})(?=\s+\d{2}:\d{2}:\d{2})/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractOperationTime($text)
    {
        preg_match('/(\d{2}:\d{2}:\d{2})/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }

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

    private function CONCEPTO($text)
    {
        preg_match('/CONCEPTO DE PAGO:\s*(\d+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }

    private function TICKET($text)
    {
        preg_match('/NRO. TICKET:\s*(\d+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractName($text)
    {
        preg_match('/NOMBRE:\s*(.+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    

    private function extractTotalAmount($text)
    {
      // Busca la línea que contiene "IMPORTE TOTAL"
    preg_match('/.*IMPORTE TOTAL:.*?(\d+(?:\.\d{2})?)/', $text, $matches);
    return $matches[1] ?? 'No encontrado';
   
    }
    


}