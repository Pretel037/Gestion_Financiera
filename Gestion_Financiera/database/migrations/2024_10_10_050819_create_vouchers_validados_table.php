<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vouchers_validados', function (Blueprint $table) {
            $table->id();
            $table->string('numero_operacion');
            $table->dateTime('fecha_pago');
            $table->decimal('monto', 8, 2);
            $table->string('dni_codigo');
            $table->string('nombres');
            $table->string('nombre_curso_servicio');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vouchers_validados');
    }

};
