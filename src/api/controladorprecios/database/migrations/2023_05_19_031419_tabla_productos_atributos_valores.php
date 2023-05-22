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
        Schema::create('productosatributosvalores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productoId');
            $table->unsignedBigInteger('atributoId');
            $table->string('valor');
            $table->unsignedBigInteger('unidadmedidaId');
            $table->unsignedBigInteger('marcaId');
            $table->boolean("activo")->default(true);
            $table->dateTime("fecha_eliminado")->nullable();
            $table->timestamps();
            $table->foreign('productoId')->references('id')->on('productos');
            $table->foreign('atributoId')->references('id')->on('atributos');
            $table->foreign('unidadmedidaId')->references('id')->on('unidadesmedidas')->nullable();
            $table->foreign('marcaId')->references('id')->on('marcas')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productosatributosvalores');
    }
};
