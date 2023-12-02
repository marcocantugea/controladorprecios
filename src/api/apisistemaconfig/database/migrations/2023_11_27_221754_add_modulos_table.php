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
        Schema::create('modulos_sistema', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->string('nombre');
            $table->string('display');
            $table->boolean('activo');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();

            $table->index('publicId','Inx_modulos_publicId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos_sistema');
    }
};
