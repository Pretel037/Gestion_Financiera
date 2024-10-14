<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id(); // ID del docente
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla users
            $table->string('first_name'); // Nombre del docente
            $table->string('last_name'); // Apellido del docente
            $table->string('dni')->unique(); // DNI del docente
            $table->date('birth_date'); // Fecha de nacimiento
            $table->string('subject')->nullable(); // Materia que enseña
            $table->string('address')->nullable(); // Dirección del docente
            $table->string('phone')->nullable(); // Teléfono del docente
            $table->string('profile_image')->nullable(); // URL de la imagen de perfil
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};