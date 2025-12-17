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
    Schema::create('locations', function (Blueprint $table) {
        $table->id();

        // siapa yang input data (SA/AR)
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // data inti
        $table->string('name', 150);
        $table->text('address');

        // koordinat presisi (DOUBLE)
        $table->double('latitude');
        $table->double('longitude');

        // customer vs non-customer
        $table->enum('type', ['customer', 'non_customer']);

        // segmen (7 kategori)
        $table->enum('segment', [
            'sekolah', 'ruko', 'hotel',
            'multifinance', 'health',
            'ekspedisi', 'energi'
        ]);

        // status verifikasi admin
        $table->enum('status', ['pending', 'approved'])->default('pending');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
