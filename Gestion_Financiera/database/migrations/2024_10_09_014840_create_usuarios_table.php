<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' autoincremental
            $table->string('name'); // Nombre del usuario
            $table->string('email')->unique(); // Correo electrónico único
            $table->string('password'); // Contraseña
            $table->rememberToken(); // Token para recordar la sesión
            $table->timestamps(); // Tiempos de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
