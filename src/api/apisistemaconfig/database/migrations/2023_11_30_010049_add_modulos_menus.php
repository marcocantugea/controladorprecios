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
        Schema::create('modulos_menus_sistema', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->uuid('moduloPid');
            $table->uuid('menuPid');
            $table->unsignedInteger('moduloId');
            $table->unsignedInteger('menuId');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();

            $table->index('publicId','Indx_modulos_menus_sistema_publicId');
            $table->index('moduloPid','Indx_modulos_menus_sistema_moduloPid');
            $table->index('menuPid','Indx_modulos_menus_sistema_menuPid');
            $table->index('moduloId','Indx_modulos_menus_sistema_moduloId');
            $table->index('menuId','Indx_modulos_menus_sistema_menuId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos_menus_sistema');
    }
};
