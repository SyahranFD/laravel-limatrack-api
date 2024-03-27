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
        Schema::create('carts', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->string('pedagang_id');
            $table->string('jajanan_id');
            $table->integer('jumlah');
            $table->integer('total_harga');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pedagang_id')->references('id')->on('pedagangs');
            $table->foreign('jajanan_id')->references('id')->on('jajanans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
