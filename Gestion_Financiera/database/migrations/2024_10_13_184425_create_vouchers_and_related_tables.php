<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Crear la tabla pagos_s_i_g_g_a_s primero
        Schema::create('pagos_s_i_g_g_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('numero_operacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->decimal('monto_pago', 8, 2);
            $table->dateTime('fecha_pago');
            $table->time('hora'); 
            $table->string('dni');
            $table->string('sucursal');
            $table->timestamps();

        });

        // Crear la tabla vouchers
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha'); // Fecha del voucher
            $table->time('hora'); // Hora del voucher
            $table->string('operacion'); // Número de operación
            $table->decimal('monto', 8, 2); // Monto del voucher
            $table->string('codigo_dni'); // Código de DNI
            $table->string('servicio'); // Servicio asociado al voucher
            $table->timestamps();
        });

        // Crear la tabla vouchers_validados
        Schema::create('vouchers_validados', function (Blueprint $table) {
            $table->id();
            $table->string('numero_operacion');
            $table->dateTime('fecha_pago');
            $table->decimal('monto', 8, 2);
            $table->string('dni_codigo');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('nombre_curso_servicio');
            $table->boolean('estado')->default(false);
            $table->unsignedBigInteger('voucher_id'); // Clave foránea para vouchers
            $table->unsignedBigInteger('pagos_siga_id'); // Clave foránea para vouchers
            
            $table->timestamps();
            
            // Definición de las claves foráneas
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->foreign('pagos_siga_id')->references('id')->on('pagos_s_i_g_g_a_s')->onDelete('cascade');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('vouchers_validados');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('pagos_s_i_g_g_a_s');
    }
};