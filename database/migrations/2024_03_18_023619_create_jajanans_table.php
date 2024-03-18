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
        Schema::create('jajanans', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('pedagang_id');
            $table->string('nama');
            $table->string('deskripsi');
            $table->float('harga');
            $table->string('image');
            $table->boolean('tersedia');
            $table->string('kategori');
            $table->timestamps();

            $table->foreign('pedagang_id')->references('id')->on('pedagangs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jajanans');
    }
};
