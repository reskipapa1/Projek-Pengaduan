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
        Schema :: table ('users', function (Blueprint $table){
            $table->string('Nik', 16)->unique()->after('id');
            $table->enum('alamat', ['bukit_raya', 'bina_widya', 'marpoyan_damai', 'senapelan', 'rumbai'])->nullable();
            $table->string('no_telp', 13)->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('users', function (Blueprint $table){
            $table->dropUnique(['Nik']);
            $table->dropUnique(['no_telp']);
            $table->dropColumn(['Nik','alamat','no_telp']);
        });
    }
};
