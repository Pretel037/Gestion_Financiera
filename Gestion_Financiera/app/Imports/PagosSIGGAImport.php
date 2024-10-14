<?php

namespace App\Imports;

use App\Models\PagosSIGGA;


class PagosSIGGAImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Verificar si se ha cargado un archivo
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->getRealPath(); // Obtener la ruta temporal del archivo cargado

            // Usar SimpleXLSX para parsear el archivo
            require_once app_path('Imports/SimpleXLSX.php'); // Incluir SimpleXLSX

            if ($xlsx = SimpleXLSX::parse($filePath)) {
                foreach ($xlsx->rows() as $row) {
                    // Insertar los datos en la base de datos
                    PagosSIGGA::create([
                        'monto' => $row[0],
                        'alumno' => $row[1],
                        'curso' => $row[2],
                        'fechade_pago' => date('Y-m-d', strtotime($row[3])),
                    ]);
                }
                return redirect()->back()->with('success', 'Datos importados exitosamente');
            } else {
                return redirect()->back()->with('error', SimpleXLSX::parseError());
            }
        } else {
            return redirect()->back()->with('error', 'No se ha subido ningún archivo');
        }
    }
}
