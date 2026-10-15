<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE mahasiswa MODIFY COLUMN status ENUM('pending', 'active', 'rejected', 'nonaktif') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE mahasiswa MODIFY COLUMN status ENUM('pending', 'active', 'rejected') DEFAULT 'pending'");
    }
};
