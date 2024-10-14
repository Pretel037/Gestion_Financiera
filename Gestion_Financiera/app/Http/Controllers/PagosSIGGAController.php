<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagosSiggass;
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
                    // Ignorar la primera fila si contiene encabezados
                    if ($index == 0) {
                        continue;
                    }
            
                    // Validar que los datos no sean nulos y tengan el formato correcto
                    $numero_operacion = isset($row[0]) ? $row[0] : ''; 
                    $nombres = isset($row[1]) ? $row[1] : ''; 
                    $apellidos = isset($row[2]) ? $row[2] : ''; 
                    $monto_pago = is_numeric($row[3]) ? $row[3] : 0; // Cambia a 0 si no es numérico
                    $fecha_pago = isset($row[4]) ? date('Y-m-d', strtotime($row[4])) : date('Y-m-d'); // Valor por defecto hoy si no está
                    $hora = isset($row[5]) ? $row[5] : ''; 
                    $dni = isset($row[6]) ? $row[6] : ''; 
                    $sucursal = isset($row[7]) ? $row[7] : ''; 

                    // Insertar los datos en la base de datos
                    PagosSiggass::create([
                        'numero_operacion' => $numero_operacion,
                        'nombres' => $nombres,
                        'apellidos' => $apellidos,
                        'monto_pago' => $monto_pago,
                        'fecha_pago' => $fecha_pago,
                        'hora' => $hora,
                        'dni' => $dni,
                        'sucursal' => $sucursal,
                    ]);
                }
                return redirect()->back()->with('success', 'Datos importados exitosamente');
            } else {
                return redirect()->back()->with('error', SimpleXLSX::parseError());
            }
            
        } else {
            return redirect()->back()->with('error', 'Por favor, cargue un archivo válido');
        }
    }
}
