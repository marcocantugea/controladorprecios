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
        Schema::create('equivalencias', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->unsignedBigInteger('productoId');
            $table->unsignedBigInteger('productoIdEqu');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();
            $table->foreign('productoId')->references('id')->on('productos');
            $table->foreign('productoIdEqu')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equivalencias');
    }
};
