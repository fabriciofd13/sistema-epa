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
        Schema::create('historial_academicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alumno');
            $table->foreign('id_alumno')
                ->references('id')->on('alumnos')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_curso');
            $table->foreign('id_curso')
                ->references('id')->on('curso_divisions')
                ->onDelete('cascade');
            $table->year('anio_lectivo');
            $table->decimal('promedio_anual', 4, 2)->nullable();
            //Agregado
            $table->integer('pago_cooperadora')->nullable();
            //
            $table->integer('create_user_id')->nullable();
            $table->integer('update_user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_academicos');
    }
};
