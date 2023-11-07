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
        Schema::create('organizacion', function (Blueprint $table) {
            $table->id();
            $table->uuid("publicId")->default(uniqid());
            $table->string("nombre",100);
            $table->text("descripcion");
            $table->string("codigo",17);
            $table->timestamps();
            $table->dateTime("fecha_eliminado")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizacion');
    }
};
