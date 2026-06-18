<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('owner_name', 100)->nullable()->after('name');
            $table->string('phone', 20)->nullable()->after('owner_name');
            $table->string('business_detail', 200)->nullable()->after('phone');
            $table->enum('omset', [
                'di_bawah_5jt',
                '5jt_20jt',
                '20jt_50jt',
                '50jt_100jt',
                'di_atas_100jt',
            ])->nullable()->after('business_detail');
            $table->string('paket_langganan', 100)->nullable()->after('omset');
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['owner_name', 'phone', 'business_detail', 'omset', 'paket_langganan']);
        });
    }
};
