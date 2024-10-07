<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagos_s_i_g_g_a_s', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 8, 2);
            $table->string('alumno');
            $table->string('curso');
            $table->date('fechade_pago');
            $table->timestamps(); // Esto agregará columnas created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos_s_i_g_g_a_s');
    }
};
