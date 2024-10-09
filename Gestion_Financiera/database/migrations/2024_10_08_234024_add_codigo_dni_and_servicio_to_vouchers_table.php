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
    Schema::table('vouchers', function (Blueprint $table) {
        $table->string('codigo_dni');
        $table->string('servicio');
    });
}

public function down()
{
    Schema::table('vouchers', function (Blueprint $table) {
        $table->dropColumn(['codigo_dni', 'servicio']);
    });
}
};
