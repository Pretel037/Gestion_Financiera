<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosSiggass extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla
    protected $table = 'pagos_s_i_g_g_a_s';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'numero_operacion',
        'nombres',
        'apellidos',
        'monto_pago',
        'fecha_pago',
        'hora',
        'dni',
        'sucursal',
    ];

    /**
     * Relación con la tabla VoucherValidado, si es necesario
     */
    public function validaciones()
    {
        return $this->hasMany(VoucherValidado::class, 'pagos_siga_id');
    }
}
