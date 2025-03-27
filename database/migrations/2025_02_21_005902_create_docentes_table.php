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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('apellido', 100);
            $table->string('nombre', 100);            
            $table->string('dni', 10)->unique();
            $table->string('cuil', 15)->unique();
            $table->date('fecha_nacimiento');
            //
            $table->string('email', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            //
            $table->string('titulo', 100)->nullable();
            $table->string('segundo_titulo', 255)->nullable();
            //
            $table->string('localidad', 255)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('barrio', 100)->nullable();
            $table->string('numero', 10)->nullable();
            //
            $table->string('observaciones', 500)->nullable();
            //
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_ingreso_epa')->nullable();
            $table->boolean('declaracion_jurada')->nullable();
            $table->string('legajo',10)->nullable();
            $table->string('horas_epa',10)->nullable();
            $table->string('horas_totales',10)->nullable();
            //
            $table->integer('create_user_id')->nullable();
            $table->integer('update_user_id')->nullable();
            $table->timestamps();            
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
