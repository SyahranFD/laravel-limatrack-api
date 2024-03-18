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
            $table->string('image');
            $table->boolean('buka');
            $table->string('jam_buka');
            $table->string('jam_tutup');
            $table->string('daerah_dagang');
            $table->float('average_rating');
            $table->boolean('sertifikasi_halal');
            $table->string('latitude');
            $table->string('longitude');
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
