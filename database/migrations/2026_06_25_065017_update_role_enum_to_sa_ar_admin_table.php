<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Expand enum dulu ke 4 nilai supaya UPDATE tidak tertolak strict mode
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','user','sa','ar') NOT NULL DEFAULT 'sa'");

        // 2) Migrasikan semua 'user' yang ada jadi 'sa'
        DB::statement("UPDATE users SET role = 'sa' WHERE role = 'user'");

        // 3) Sempitkan kembali enum ke nilai final: admin/sa/ar
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','sa','ar') NOT NULL DEFAULT 'sa'");
    }

    public function down(): void
    {
        // Expand dulu supaya UPDATE tidak tertolak
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','user','sa','ar') NOT NULL DEFAULT 'user'");

        // Kembalikan sa/ar jadi user
        DB::statement("UPDATE users SET role = 'user' WHERE role IN ('sa','ar')");

        // Sempitkan ke enum lama
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','user') NOT NULL DEFAULT 'user'");
    }
};
