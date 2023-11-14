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
        Schema::table('atributos', function (Blueprint $table) {
            $table->index('publicId','Indx_atributos_publicId');
        });
        
        Schema::table('categorias', function (Blueprint $table) {
            $table->index('publicId','Indx_categorias_publicId');
        });

        Schema::table('costos', function (Blueprint $table) {
            $table->index('publicId','Indx_costos_publicId');
        });

        Schema::table('marcas', function (Blueprint $table) {
            $table->index('publicId','Indx_marcas_publicId');
        });

        Schema::table('proveedores', function (Blueprint $table) {
            $table->index('publicId','Indx_proveedores_publicId');
        });

        Schema::table('unidadesmedidas', function (Blueprint $table) {
            $table->index('publicId','Indx_unidadesmedidas_publicId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atributos', function (Blueprint $table) {
            $table->dropIndex('Indx_atributos_publicId');
        });

        Schema::table('categorias', function (Blueprint $table) {
            $table->dropIndex('Indx_categorias_publicId');
        });

        Schema::table('costos', function (Blueprint $table) {
            $table->dropIndex('Indx_costos_publicId');
        });

        Schema::table('marcas', function (Blueprint $table) {
            $table->dropIndex('Indx_marcas_publicId');
        });

        Schema::table('proveedores', function (Blueprint $table) {
            $table->dropIndex('Indx_proveedores_publicId');
        });

        Schema::table('unidadesmedidas', function (Blueprint $table) {
            $table->dropIndex('Indx_unidadesmedidas_publicId');
        });
    }
};
