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
        Schema::create('listasprecios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('publicId');
            $table->string('descripcion')->nullable(true);
            $table->string('codigo')->nullable(true);
            $table->boolean('activo')->default(false);
            $table->dateTime('fecha_eliminado')->nullable(true);
            $table->dateTime('fecha_expira')->nullable(true);
            $table->dateTime('fecha_inicia')->nullable(true);
            $table->index('publicId','Inx_listasprecios_publicId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listasprecios');
    }
};
