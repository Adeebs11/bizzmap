<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) ubah semua 'sa' dan 'ar' jadi 'user' supaya tidak error saat enum diganti
        DB::statement("UPDATE users SET role = 'user' WHERE role IN ('sa', 'ar')");

        // 2) ubah definisi enum role
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','user') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        // kalau suatu saat rollback, kita kembalikan seperti semula
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','sa','ar') NOT NULL DEFAULT 'sa'");
    }
};
