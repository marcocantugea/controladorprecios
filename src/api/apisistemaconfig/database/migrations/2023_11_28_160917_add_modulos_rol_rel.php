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
        Schema::create('roles_modulos', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->uuid('rolPid');
            $table->uuid('moduloPid');
            $table->unsignedBigInteger('moduloId');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();

            $table->index('publicId','Inx_roles_modulos_publicId');
            $table->index('rolPid','Inx_roles_modulos_rolPid');
            $table->index('moduloPid','Inx_roles_modulos_moduloPid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_modulos');
    }
};
