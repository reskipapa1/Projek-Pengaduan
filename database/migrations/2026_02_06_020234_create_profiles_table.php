<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            // Kolom ini mengunci relasi One-to-One
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
             $table->string('Nik', 16)->unique();
            // Kolom pindahan dari tabel users
            $table->string('name');
            $table->string('no_telp', 13)->nullable();
            $table->string('alamat')->nullable();
            
            $table->string('foto_profil')->nullable();
            $table->timestamps();
        });

        // (Opsional) Hapus kolom lama di users agar tidak duplikat
        // Hati-hati: Pastikan backup data dulu jika ini aplikasi yang sudah jalan!
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'no_telp', 'alamat', 'Nik']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
        
        // Kembalikan kolom ke users jika rollback
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('Nik', 16)->unique()->after('id');
        });
    }
};
