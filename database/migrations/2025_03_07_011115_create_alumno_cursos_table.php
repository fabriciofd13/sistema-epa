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
        Schema::create('alumno_cursos', function (Blueprint $table) {
            $table->id();
            $table->year('anio_lectivo');
            $table->unsignedBigInteger('id_preceptor')->nullable();
            $table->foreign('id_preceptor')
                ->references('id')->on('preceptors')
                ->onDelete('set null');
            $table->integer('preceptor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno_cursos');
    }
};
