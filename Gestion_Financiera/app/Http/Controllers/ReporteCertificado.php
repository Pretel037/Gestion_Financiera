<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use DB;

class ReporteCertificado extends Controller
{
    public function obtenerPagos(Request $request)
    {
        $query = DB::table('vouchers_validados')
            ->select(
                'vouchers_validados.nombre_curso_servicio as nombre_certificado',
                'vouchers_validados.numero_operacion',
                'vouchers_validados.fecha_pago',
                DB::raw('SUM(vouchers_validados.monto) as total_monto')
            )
            ->whereIn('vouchers_validados.nombre_curso_servicio', function($subquery) {
                $subquery->select('nombre')->from('certificados');
            });

        // Filtra por el mes actual si no se especifica un rango de fechas
        if (!$request->filled('fecha_inicio') && !$request->filled('fecha_fin')) {
            $query->whereYear('vouchers_validados.fecha_pago', Carbon::now()->year)
                  ->whereMonth('vouchers_validados.fecha_pago', Carbon::now()->month);
        }

        // Filtra por rango de fechas si están presentes
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            // Convierte las fechas a formato 'Y-m-d'
            $fechaInicio = Carbon::createFromFormat('Y-m-d', $request->fecha_inicio)->startOfDay();
            $fechaFin = Carbon::createFromFormat('Y-m-d', $request->fecha_fin)->endOfDay();
            
            $query->whereBetween('vouchers_validados.fecha_pago', [$fechaInicio, $fechaFin]);
        }

        // Agrupa por certificado y número de operación
        $query->groupBy('vouchers_validados.nombre_curso_servicio', 'vouchers_validados.numero_operacion', 'vouchers_validados.fecha_pago');

        $pagos = $query->get();

        // Retorna la vista principal con los datos
        return view('reporte_certificados', compact('pagos'));
    }

    public function generarPDF(Request $request)
    {
        $query = DB::table('vouchers_validados')
            ->select(
                'vouchers_validados.nombre_curso_servicio as nombre_certificado',
                'vouchers_validados.numero_operacion',
                'vouchers_validados.fecha_pago',
                DB::raw('SUM(vouchers_validados.monto) as total_monto')
            )
            ->whereIn('vouchers_validados.nombre_curso_servicio', function($subquery) {
                $subquery->select('nombre')->from('certificados');
            });
        
        $fechaInicio = null;
        $fechaFin = null;

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $fechaInicio = Carbon::createFromFormat('Y-m-d', $request->fecha_inicio)->startOfDay();
            $fechaFin = Carbon::createFromFormat('Y-m-d', $request->fecha_fin)->endOfDay();
            
            $query->whereBetween('vouchers_validados.fecha_pago', [$fechaInicio, $fechaFin]);
        } else {
            $fechaInicio = Carbon::now()->startOfMonth();
            $fechaFin = Carbon::now()->endOfMonth();
            
            $query->whereYear('vouchers_validados.fecha_pago', Carbon::now()->year)
                  ->whereMonth('vouchers_validados.fecha_pago', Carbon::now()->month);
        }

        // Agrupa por certificado y número de operación
        $query->groupBy('vouchers_validados.nombre_curso_servicio', 'vouchers_validados.numero_operacion', 'vouchers_validados.fecha_pago');

        $pagos = $query->get();

        $data = [
            'pagos' => $pagos,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ];

        $pdf = PDF::loadView('reporte_certificados1', $data);
        
        // Configura el PDF para mejor visualización
        $pdf->setPaper('A4', 'landscape');
        
        // Descarga el PDF
        return $pdf->download('reporte_certificados.pdf');
    }
}
