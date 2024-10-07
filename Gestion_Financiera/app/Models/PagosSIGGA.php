<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosSIGGA extends Model
{

    use HasFactory;

    protected $fillable = [
        'id',
        'monto',
        'alumno',
        'curso',
        'fechade_pago',
    ];
}
