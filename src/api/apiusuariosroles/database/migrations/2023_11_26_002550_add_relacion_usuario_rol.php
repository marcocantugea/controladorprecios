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
        Schema::create('usuario_rol', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->unsignedBigInteger('usuarioId');
            $table->unsignedBigInteger('rolId');
            $table->uuid('usuarioPid');
            $table->uuid('rolPid');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();

            $table->index('publicId','Indx_usuario_rol_publicId');
            $table->index('rolPid','Indx_usuario_rol_rolPid');
            $table->index('usuarioPid','Indx_usuario_rol_usuarioPid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_rol');
    }
};
