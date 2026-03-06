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
        //
        Schema::create('penugasan', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('pengaduan_id');
            $table->unsignedBigInteger('petugas_id');
            $table->enum('status_penugasan', ['ditugaskan', 'selesai'])->default('ditugaskan');
            $table->timestamp('penugasan_dilakukan')->useCurrent();
            $table->timestamp('penugasan_selesai')->nullable();
            $table->foreign('petugas_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pengaduan_id')->references('id')->on('pengaduan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan');
    }
};
