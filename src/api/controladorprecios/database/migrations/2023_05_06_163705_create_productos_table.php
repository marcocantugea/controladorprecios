<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Rfc4122\UuidV4;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->uuid("publicId")->default(uniqid());
            $table->string("nombre",100);
            $table->text("descripcion");
            $table->string("codigo",17);
            $table->string("sku",50)->nullable();
            $table->string("upc",50)->nullable();
            $table->string("ean",50)->nullable();
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
        Schema::dropIfExists('productos');
    }
};
