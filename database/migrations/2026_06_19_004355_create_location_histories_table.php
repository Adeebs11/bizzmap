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
        Schema::create('location_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')
                  ->constrained('locations')
                  ->cascadeOnDelete();
            $table->foreignId('changed_by')
                  ->constrained('users');
            $table->enum('old_status', ['pending', 'approved'])->nullable();
            $table->enum('new_status', ['pending', 'approved']);
            $table->string('note', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_histories');
    }
};
