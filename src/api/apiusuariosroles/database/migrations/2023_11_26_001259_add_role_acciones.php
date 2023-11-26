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
        Schema::create('roles_acciones_sistema', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->unsignedBigInteger('rolId');
            $table->unsignedBigInteger('accionId');
            $table->uuid('rolPid');
            $table->uuid('accionPid');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();

            $table->index('publicId','Indx_roles_acciones_sistema_publicId');
            $table->index('rolPid','Indx_roles_acciones_sistema_rolPid');
            $table->index('accionPid','Indx_roles_acciones_sistema_accionPid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_acciones_sistema');
    }
};
