<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonthlyReport;

use PDF;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{
    public function obtenerPagos(Request $request)
    {
        $query = DB::table('vouchers_validados')
        ->join('courses', 'vouchers_validados.nombre_curso_servicio', '=', 'courses.name')
        ->join('course_user', 'courses.id', '=', 'course_user.course_id')
        ->join('users', 'course_user.user_id', '=', 'users.id')
        ->join('teachers', 'users.id', '=', 'teachers.user_id')
        ->select(
            'vouchers_validados.nombre_curso_servicio',
            DB::raw('COUNT(vouchers_validados.numero_operacion) as numero_vouchers'),
            DB::raw('SUM(vouchers_validados.monto) as total_monto'),
            DB::raw('GROUP_CONCAT(vouchers_validados.numero_operacion) as numero_operacion'),
            'teachers.first_name', 
            'teachers.last_name'
        );

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

    // Asegúrate de incluir las columnas en el GROUP BY
    $query->groupBy('vouchers_validados.nombre_curso_servicio', 'teachers.first_name', 'teachers.last_name');

    $pagos = $query->get();


    // Retorna la vista principal con los datos
    return view('cursos_reporte', compact('pagos'));
    }

    public function generarPDF(Request $request)
    {
        $query = DB::table('vouchers_validados')
        ->join('courses', 'vouchers_validados.nombre_curso_servicio', '=', 'courses.name')
        ->join('course_user', 'courses.id', '=', 'course_user.course_id')
        ->join('users', 'course_user.user_id', '=', 'users.id')
        ->join('teachers', 'users.id', '=', 'teachers.user_id')
        ->select(
            'vouchers_validados.nombre_curso_servicio',
            DB::raw('COUNT(vouchers_validados.numero_operacion) as numero_vouchers'),
            DB::raw('SUM(vouchers_validados.monto) as total_monto'),
            DB::raw('GROUP_CONCAT(vouchers_validados.numero_operacion) as numero_operacion'),
            'teachers.first_name', 
            'teachers.last_name'
        );
    
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

    $query->groupBy('vouchers_validados.nombre_curso_servicio', 'teachers.first_name', 'teachers.last_name');
    $pagos = $query->get();

    $data = [
        'pagos' => $pagos,
        'fechaInicio' => $fechaInicio,
        'fechaFin' => $fechaFin
    ];

    $pdf = PDF::loadView('reporte_cursos_pdf', $data);
    
    // Configura el PDF para mejor visualización
    $pdf->setPaper('A4', 'landscape');
    
    // Descarga el PDF
    return $pdf->download('reporte_cursos.pdf');
    }

    
}
