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
        Schema::create('unidadesmedidas', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->string('unidadMedida')->require()->max(50);
            $table->string('codigo')->require()->max(30);
            $table->boolean("activo")->default(true);
            $table->timestamps();
            $table->dateTime("fecha_eliminado")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidadesmedidas');
    }
};
