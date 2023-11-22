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
        Schema::create('canalventa_listaprecio', function (Blueprint $table) {
            $table->id();
            $table->uuid('publicId');
            $table->uuid('listaPid');
            $table->uuid('canalventaPid');
            $table->unsignedBigInteger('canalventaId');
            $table->timestamps();
            $table->dateTime('fecha_eliminado')->nullable();

            $table->index('publicId','Inx_canalventa_listaprecio_publicId');
            $table->index('listaPid','Inx_canalventa_listaprecio_listaPid');
            $table->index('canalventaPid','Inx_canalventa_listaprecio_canalventaPid');
            $table->index('canalventaId','Inx_canalventa_listaprecio_canalventaId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canalventa_listaprecio');
    }
};
