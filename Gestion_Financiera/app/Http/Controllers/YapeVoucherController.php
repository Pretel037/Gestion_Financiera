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
    
        $image = $request->file('voucher_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/vouchers', $imageName);
    
        $fullImagePath = storage_path('app/public/vouchers/' . $imageName);
    
        if (!file_exists($fullImagePath)) {
            return "Error: Imagen no encontrada en la ruta: " . $fullImagePath;
        }
    
        $ocr = new TesseractOCR($fullImagePath);
        $text = $ocr->run();
    
        $monto = $this->extractMonto($text);
        $yapero = $this->extractYapero($text);
        $celularYapero = $this->extractCelularYapero($text);
        $fechaHora = $this->extractFechaHora($text);
        $celularBeneficiario = $this->extractCelularBeneficiario($text);
        $nombreBeneficiario = $this->extractNombreBeneficiario($text);
        $numeroOperacion = $this->extractNumeroOperacion($text);
    
        return view('voucher.Yaperesul', compact('monto', 'yapero', 'celularYapero', 'fechaHora', 'celularBeneficiario', 'nombreBeneficiario', 'numeroOperacion'));
    }
    
    private function extractMonto($text)
    {
        preg_match('/S\/\s?(\d+\.\d{2})/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractYapero($text)
    {
        preg_match('/Yapero\s+(.*)/i', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractCelularYapero($text)
    {
        preg_match('/Tu número de celular\s+(\w+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractFechaHora($text)
    {
        preg_match('/Fecha y Hora de la\s+operación\s+(.*)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractCelularBeneficiario($text)
    {
        preg_match('/Celular del Beneficiario\s+(\w+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractNombreBeneficiario($text)
    {
        preg_match('/Nombre del Beneficiario\s+(.*)/i', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
    
    private function extractNumeroOperacion($text)
    {
        preg_match('/N° de operación:\s+(\d+)/', $text, $matches);
        return $matches[1] ?? 'No encontrado';
    }
}