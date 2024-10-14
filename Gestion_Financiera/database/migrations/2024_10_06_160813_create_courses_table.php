<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); // ID del curso
            $table->string('course_id')->unique(); // Código del curso
            $table->string('name'); // Nombre del curso
            $table->string('period'); // Período o semestre
            $table->string('session_link'); // Período o semestre
            $table->text('description')->nullable(); // Descripción del curso (opcional)
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};