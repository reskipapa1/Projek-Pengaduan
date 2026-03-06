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
        Schema::table('pengaduan',function(Blueprint $table){
            $table->string('lokasi')->change();
            $table->string('kategori')->change();
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('pengaduan', function (Blueprint $table) {
            $table->enum('lokasi', [
                'bukit_raya',
                'bina_widya',
                'marpoyan_damai',
                'senapelan',
                'rumbai'
            ])->change();

            $table->enum('kategori', ['tps', 'lps'])->change();

            $table->enum('status', ['pending', 'proses', 'selesai'])
                  ->default('pending')
                  ->change();
        });
    }
};
