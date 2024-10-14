<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{

    use HasFactory;

    // Especificamos la tabla asociada si es diferente del plural del modelo
    protected $table = 'monthly_reports';

    // Campos que pueden ser llenados masivamente
    protected $fillable = [
        'course_name',
        'teacher_name',
        'total_students',
        'total_amount',
        'report_month'
    ];
}
