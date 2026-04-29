<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('peminjamans') && Schema::hasColumn('peminjamans', 'status')) {
            // First expand the enum to include all possible values
            DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('dipinjam','dikembalikan','pending','approved','rejected') NOT NULL DEFAULT 'pending'");

            // Then update existing data
            DB::table('peminjamans')->where('status', 'dipinjam')->update(['status' => 'approved']);
            DB::table('peminjamans')->where('status', 'dikembalikan')->update(['status' => 'rejected']);

            // Finally set the final enum values
            DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('peminjamans') && Schema::hasColumn('peminjamans', 'status')) {
            // First expand the enum to include all possible values for rollback
            DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('dipinjam','dikembalikan','pending','approved','rejected') NOT NULL DEFAULT 'dipinjam'");

            // Then update existing data back
            DB::table('peminjamans')->where('status', 'approved')->update(['status' => 'dipinjam']);
            DB::table('peminjamans')->where('status', 'rejected')->update(['status' => 'dikembalikan']);
            DB::table('peminjamans')->where('status', 'pending')->update(['status' => 'dipinjam']);

            // Finally set the original enum values
            DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('dipinjam','dikembalikan') NOT NULL DEFAULT 'dipinjam'");
        }
    }
};
