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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_materia')->nullable();
            $table->foreign('id_materia')
                ->references('id')->on('materias')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_historial_academico')->nullable();
            $table->foreign('id_historial_academico') 
                ->references('id')->on('historial_academicos')
                ->onDelete('cascade');

            //
            $table->decimal('primer_trimestre', 4, 2)->nullable();
            $table->decimal('segundo_trimestre', 4, 2)->nullable();
            $table->decimal('tercer_trimestre', 4, 2)->nullable();
            $table->decimal('nota_final', 4, 2)->nullable(); //hace referencia a la nota final
            $table->decimal('nota_diciembre', 4, 2)->nullable();
            $table->decimal('nota_febrero', 4, 2)->nullable();
            $table->decimal('previa', 4, 2)->nullable();
            $table->decimal('definitiva', 4, 2)->nullable();
            $table->string('observacion_previas', 500)->nullable();
            //
            $table->string('observacion_1', 500)->nullable();
            $table->string('observacion_2', 500)->nullable();
            $table->string('observacion_3', 500)->nullable();
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
        Schema::dropIfExists('notas');
    }
};
