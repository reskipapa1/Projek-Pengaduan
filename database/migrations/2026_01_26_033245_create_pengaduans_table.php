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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('lokasi',['bukit_raya', 'bina_widya', 'marpoyan_damai', 'senapelan', 'rumbai']);
            $table->string('alamat');
            $table->enum('kategori', ['tps', 'lps']);
            $table->text('isi_laporan');
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
