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
        Schema::create('pedagangs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->string('nama_warung');
            $table->string('nama_pedagang');
            $table->string('banner')->nullable()->default(null);
            $table->string('status')->default('tutup');
            $table->string('jam_buka');
            $table->string('jam_tutup');
            $table->string('daerah_dagang');
            $table->float('average_rating')->default(0);
            $table->string('dokumen_sertifikat_halal')->nullable()->default(null);
            $table->boolean('sertifikasi_halal')->default(false);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagangs');
    }
};
