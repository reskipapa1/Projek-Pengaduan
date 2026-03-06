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
        Schema::create('lps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_lps');
            $table->string('wilayah_layanan');
            $table->enum('status_operasional',['aktif','non_aktif']);
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lps');
    }
};
