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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('mahasiswa_npm', 14);
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tenggat_waktu');
            $table->date('tanggal_kembali')->nullable();
            $table->string('status')->default('Dipinjam'); // 'Dipinjam', 'Selesai'
            $table->timestamps();

            // Setup foreign key manually for mahasiswa_npm because it's string
            $table->foreign('mahasiswa_npm')->references('npm')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
