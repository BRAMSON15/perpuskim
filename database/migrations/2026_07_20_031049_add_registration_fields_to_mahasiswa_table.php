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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('fakultas')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_kartu')->nullable();
            $table->enum('status', ['pending', 'active', 'rejected'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['fakultas', 'alamat', 'foto_kartu', 'status']);
        });
    }
};
