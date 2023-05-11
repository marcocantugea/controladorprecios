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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->uuid("publicId");
            $table->string("nombre",100);
            $table->boolean("activo")->default(true);
            $table->timestamps();
            $table->dateTime("fecha_eliminado")->nullable();

        });

         Schema::create('productosCategorias', function (Blueprint $table) {
            $table->unsignedBigInteger('productoId');
            $table->unsignedBigInteger('categoriaId');
            $table->foreign('productoId')->references('id')->on('productos');
            $table->foreign('categoriaId')->references('id')->on('categorias');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productosCategorias');
        Schema::dropIfExists('categorias');

    }
};
