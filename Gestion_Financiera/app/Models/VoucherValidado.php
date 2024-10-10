<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherValidado extends Model
{
    use HasFactory;

    // If you want to specify a custom table name
    protected $table = 'vouchers_validados';

    // Specify the fillable properties if you're using mass assignment
    protected $fillable = [
        'numero_operacion',
        'fecha_pago',
        'monto',
        'dni_codigo',
        'nombres',
        'nombre_curso_servicio',
    ];
}
