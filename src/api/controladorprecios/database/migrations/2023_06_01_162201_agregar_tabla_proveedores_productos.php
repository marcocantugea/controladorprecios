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
        Schema::create('proveedoresproductos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedorId');
            $table->unsignedBigInteger('productoId');
            $table->boolean('activo');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();
            $table->foreign('proveedorId')->references('id')->on('proveedores');
            $table->foreign('productoId')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedoresproductos');
    }
};
