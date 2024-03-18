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
        Schema::create('image_verifikasi_pedagangs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('pedagang_id');
            $table->string('image');
            $table->timestamps();

            $table->foreign('pedagang_id')->references('id')->on('pedagangs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_verifikasi_pedagangs');
    }
};
