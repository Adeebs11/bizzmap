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
        Schema::table('location_histories', function (Blueprint $table) {
            $table->string('old_type', 20)->nullable()->after('new_status');
            $table->string('new_type', 20)->nullable()->after('old_type');
            $table->enum('change_type', ['status', 'type'])
                  ->default('status')
                  ->after('new_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('location_histories', function (Blueprint $table) {
            $table->dropColumn(['old_type', 'new_type', 'change_type']);
        });
    }
};
