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
        Schema::create('curso_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->year('anio_lectivo');
            $table->unsignedBigInteger('id_preceptor')->nullable();
            $table->foreign('id_preceptor')
                ->references('id')->on('preceptors')
                ->onDelete('set null');
            $table->string('anio',50)->nullable();
            $table->string('anio_unificado',50)->nullable();//sirve para aquellas especialidades que comparten curso_division
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
        Schema::dropIfExists('curso_divisions');
    }
};
