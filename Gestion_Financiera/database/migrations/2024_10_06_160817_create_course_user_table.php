<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseUserTable extends Migration
{
    public function up(): void
    {
        Schema::create('course_user', function (Blueprint $table) {
            $table->id(); // ID de la relación
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // Relación con courses
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con users
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_user');
    }
}