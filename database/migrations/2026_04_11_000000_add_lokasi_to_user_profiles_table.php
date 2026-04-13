<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->enum('lokasi', [
                'bukit_raya',
                'bina_widya',
                'marpoyan_damai',
                'senapelan',
                'rumbai',
            ])->nullable()->after('alamat')
              ->comment('Daerah penugasan khusus admin_penanganan');
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('lokasi');
        });
    }
};
