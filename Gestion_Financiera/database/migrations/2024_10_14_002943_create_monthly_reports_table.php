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
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->string('teacher_name');
            $table->integer('total_students');
            $table->decimal('total_amount', 8, 2);
            $table->date('report_month');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
