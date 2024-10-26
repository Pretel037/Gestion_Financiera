<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{

    use HasFactory;

    // Especifica la tabla si el nombre del modelo no sigue el plural por defecto
    protected $table = 'matriculas';

    // Los atributos que se pueden asignar de manera masiva (fillable)
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',

    ];
}
