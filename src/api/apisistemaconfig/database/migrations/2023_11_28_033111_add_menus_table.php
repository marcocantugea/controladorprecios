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
        Schema::create('menus_sistema', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->string('nombre');
            $table->string('display');
            $table->boolean('activo');
            $table->boolean('essubmenu');
            $table->integer('orden');
            $table->integer('submenuId')->nullable();
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();

            $table->index('publicId','Inx_modulos_publicId');
            $table->index('submenuId','Inx_modulos_submenu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus_sistema');
    }
};
