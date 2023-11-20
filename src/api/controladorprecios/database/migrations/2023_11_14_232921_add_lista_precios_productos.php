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
        Schema::create('listapreciosproductos', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->uuid('productoPId');
            $table->unsignedBigInteger('productoId');
            $table->uuid('listaPid');
            $table->unsignedBigInteger('listapreciosId');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();
            $table->float('precio',10,2);
            $table->boolean('activo');
            
            $table->index('publicId','Indx_listapreciosproductos_publicId');
            $table->index('productoId','Indx_listapreciosproductos_productoId');
            $table->index('productoPId','Indx_listapreciosproductos_productoPId');
            $table->index('listaPid','Indx_listapreciosproductos_listaPid');
            $table->index('listapreciosId','Indx_listapreciosproductos_listapreciosId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listapreciosproductos');
    }
};
