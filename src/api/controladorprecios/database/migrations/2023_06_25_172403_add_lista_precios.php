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
        Schema::create('listaprecios', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->string('nombre')->require();
            $table->string('descripcion')->require();
            $table->dateTime('fecha_inicio')->require();
            $table->dateTime('fecha_expira')->require();
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();
            $table->boolean('activo');
            $table->float('margeUtilidad')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listaprecios');
    }
};
