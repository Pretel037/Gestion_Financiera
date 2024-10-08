<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    use HasFactory;
     // Definir la tabla asociada (opcional si el nombre sigue la convención en plural)
     protected $table = 'vouchers';

     // Los campos que se pueden asignar de manera masiva
     protected $fillable = ['fecha', 'hora', 'operacion', 'monto'];
 
     // Si deseas definir los campos protegidos contra la asignación masiva, usa $guarded en lugar de $fillable
     // protected $guarded = ['id'];
}
