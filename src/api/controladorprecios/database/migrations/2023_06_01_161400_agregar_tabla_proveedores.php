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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->string('codigo')->max(35);
            $table->string('nombreCorto')->max(135);
            $table->boolean('activo');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();
        });

        Schema::create('proveedoresInfoBasic', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedorId');
            $table->uuid('publicId');
            $table->string('nombre')->max(155);
            $table->string('rasonSocial')->max(155);
            $table->string('RFC')->max(15);
            $table->boolean('activo');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();
            $table->foreign('proveedorId')->references('id')->on('proveedores');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedoresInfoBasic');
        Schema::dropIfExists('proveedores');
    }
};
