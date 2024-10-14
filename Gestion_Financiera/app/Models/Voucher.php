<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';



    protected $fillable = [
        'fecha',
        'hora',
        'operacion',
        'monto',
        'codigo_dni',
        'servicio'
    ];

    public function validaciones()
    {
        return $this->hasMany(VoucherValidado::class, 'voucher_id');
    }
}

