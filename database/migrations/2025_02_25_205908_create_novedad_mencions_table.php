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
        Schema::create('novedad_mencions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_novedad');
            $table->foreign('id_novedad')
                ->references('id')->on('novedads')
                ->onDelete('cascade');

            // Campos para la relación polimórfica
            $table->unsignedBigInteger('mencionable_id');
            $table->string('mencionable_type');

            //
            $table->integer('create_user_id')->nullable();
            $table->integer('update_user_id')->nullable();
            $table->timestamps();
            //
            $table->index(['mencionable_id', 'mencionable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedad_mencions');
    }
};
