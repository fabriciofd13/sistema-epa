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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 10)->unique();
            $table->string('cuil', 15)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            //
            $table->string('email', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            //
            $table->string('localidad', 255)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('barrio', 100)->nullable();
            $table->string('numero', 10)->nullable();
            //
            $table->string('primaria', 255)->nullable();
            //
            $table->string('parentesco_tutor', 255)->nullable();
            $table->string('nombre_tutor', 100)->nullable();
            $table->string('apellido_tutor', 100)->nullable();
            $table->string('dni_tutor', 10)->nullable();
            $table->string('cuil_tutor', 15)->nullable();
            $table->string('celular_tutor', 15)->nullable();
            //datos de inscripcion
            $table->date('fecha_inscripcion')->nullable();
            $table->boolean('inscripcion_web')->nullable();
            $table->boolean('evaluacion')->nullable();
            $table->boolean('constancia_septimo')->nullable();
            $table->boolean('partida_nacimiento')->nullable();
            $table->boolean('ficha_salud')->nullable();
            $table->boolean('fotocopia_dni')->nullable();
            $table->boolean('fotocopia_dni_tutor')->nullable();
            $table->boolean('cud')->nullable();
            $table->boolean('abanderado')->nullable();
            $table->boolean('hermanos')->nullable();

            $table->string('observacion',500)->nullable();
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
        Schema::dropIfExists('alumnos');
    }
};
