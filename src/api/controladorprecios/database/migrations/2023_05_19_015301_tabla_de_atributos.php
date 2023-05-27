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
        Schema::create('atributos', function (Blueprint $table) {
            $table->id();
            $table->uuid("publicId");
            $table->string('atributo')->require()->max(50);
            $table->boolean("activo")->default(true);
            $table->timestamps();
            $table->dateTime("fecha_eliminado")->nullable();
            $table->boolean('esSubatributo')->default(false);
        });

        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->uuid("publicId");
            $table->string('marca')->require()->max(50);
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
        Schema::dropIfExists('atributos');
        Schema::dropIfExists('marcas');
    }
};
