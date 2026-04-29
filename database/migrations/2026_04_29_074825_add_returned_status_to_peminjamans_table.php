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
        if (Schema::hasTable('peminjamans') && Schema::hasColumn('peminjamans', 'status')) {
            // Expand the enum to include 'returned' status
            DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('pending','approved','rejected','returned') NOT NULL DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('peminjamans') && Schema::hasColumn('peminjamans', 'status')) {
            // Remove 'returned' status from enum
            DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending'");
        }
    }
};
