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
        Schema::table('vouchers_validados', function (Blueprint $table) {
            // Añadimos la columna course_id_pagos como llave foránea a la tabla courses
            $table->foreignId('course_id_pagos')->constrained('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers_validados', function (Blueprint $table) {
            // Eliminamos la llave foránea antes de eliminar la columna
            $table->dropForeign(['course_id_pagos']);
            // Eliminamos la columna course_id_pagos
            $table->dropColumn('course_id_pagos');
        });
    }
};
