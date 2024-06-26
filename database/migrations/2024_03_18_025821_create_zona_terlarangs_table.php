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
        Schema::create('zona_terlarangs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('radius');
            $table->string('nama');
            $table->string('daerah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_terlarangs');
    }
};
