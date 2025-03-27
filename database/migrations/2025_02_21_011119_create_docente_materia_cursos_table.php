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
        Schema::create('docente_materia_cursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_docente');
            $table->foreign('id_docente')
                ->references('id')->on('docentes')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_materia');
            $table->foreign('id_materia')
                ->references('id')->on('materias')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_curso');
            $table->foreign('id_curso')
                ->references('id')->on('curso_divisions')
                ->onDelete('cascade');
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
        Schema::dropIfExists('docente_materia_cursos');
    }
};
