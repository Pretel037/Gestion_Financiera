<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherValidado extends Model
{
    use HasFactory;

    // Especifica la tabla si usas una diferente al plural por defecto
    protected $table = 'vouchers_validados';

    // Especifica los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'voucher_id',           // Relación con el voucher original
        'pagos_siga_id',        // Relación con pagos SIGGA
        'numero_operacion',
        'fecha_pago',
        'monto',
        'dni_codigo',
        'nombres',
        'apellidos',
        'nombre_curso_servicio', // Curso o servicio relacionado con el pago
        'estado',               // Estado de validación (1 = validado, 0 = no validado)
    ];

    /**
     * Relación con el modelo Voucher
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    /**
     * Relación con el modelo PagosSigga
     */
    public function pagosSigga()
    {
        return $this->belongsTo(PagosSigga::class, 'pagos_siga_id');
    }
}
