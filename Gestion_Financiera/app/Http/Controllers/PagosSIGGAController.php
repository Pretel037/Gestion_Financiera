<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagosSIGGA;
use Shuchkin\SimpleXLSX; // Importar la clase SimpleXLSX correctamente

class PagosSIGGAController extends Controller
{
    public function importExcel(Request $request)
    {
        // Verificar si se ha cargado un archivo
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->getRealPath(); // Obtener la ruta temporal del archivo cargado

            // Usar SimpleXLSX para parsear el archivo
            require_once app_path('Imports/SimpleXLSX.php'); // Incluir SimpleXLSX

            if ($xlsx = \Shuchkin\SimpleXLSX::parse($filePath)) {
                foreach ($xlsx->rows() as $index => $row) {
                    // Ignora la primera fila si contiene encabezados
                    if ($index == 0) {
                        continue;
                    }
            
                    // Validar que los datos no sean nulos y tengan el formato correcto
                    $monto = is_numeric($row[0]) ? $row[0] : 0; // Cambia a 0 si no es numérico
                    $alumno = isset($row[1]) ? $row[1] : ''; // Valor por defecto vacío si no está
                    $curso = isset($row[2]) ? $row[2] : ''; // Valor por defecto vacío si no está
                    $fechade_pago = isset($row[3]) ? date('Y-m-d', strtotime($row[3])) : date('Y-m-d'); // Valor por defecto hoy si no está
            
                    // Insertar los datos en la base de datos
                    PagosSIGGA::create([
                        'monto' => $monto,
                        'alumno' => $alumno,
                        'curso' => $curso,
                        'fechade_pago' => $fechade_pago,
                    ]);
                }
                return redirect()->back()->with('success', 'Datos importados exitosamente');
            } else {
                return redirect()->back()->with('error', SimpleXLSX::parseError());
            }
            
            } else {
                return redirect()->back()->with('error', 'La clase SimpleXLSX no se encuentra disponible');
            }
        
    }
}
