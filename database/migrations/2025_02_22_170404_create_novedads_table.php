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
        Schema::create('novedads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alumno');
            $table->foreign('id_alumno')
                ->references('id')->on('alumnos')
                ->onDelete('cascade');
            $table->string('detalle',4096);
            $table->date('fecha')->nullable();
            $table->string('curso',50)->nullable();
            $table->string('tipo',50)->nullable();
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
        Schema::dropIfExists('novedads');
    }
};
