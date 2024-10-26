<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuarios 
{
    use HasFactory;
    

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
