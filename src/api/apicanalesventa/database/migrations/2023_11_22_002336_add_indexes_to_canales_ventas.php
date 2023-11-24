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
        Schema::table('canalesventa', function (Blueprint $table) {
            $table->index('publicId','Indx_canalesventa_publicId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('canalesventa', function (Blueprint $table) {
            $table->dropIndex('Indx_canalesventa_publicId');
        });
    }
};
