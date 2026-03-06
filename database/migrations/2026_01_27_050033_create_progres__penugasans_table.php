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
        Schema::create('progres__penugasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penugasan_id');
            $table->text('keterangan_progres');
            $table->String('foto_bukti')->nullable();
            $table->timestamps();
            $table->foreign('penugasan_id')->references('id')->on('penugasan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres__penugasans');
    }
};
