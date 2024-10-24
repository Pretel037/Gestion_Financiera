<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    use HasFactory;

    // Especifica el nombre de la tabla asociada (opcional si sigue la convención)
    protected $table = 'courses';

    // Define los campos que se pueden llenar masivamente
    protected $fillable = [
        'course_id',
        'name',
        'period',
        'session_link',
        'description',
        'precio',
    ];
}
