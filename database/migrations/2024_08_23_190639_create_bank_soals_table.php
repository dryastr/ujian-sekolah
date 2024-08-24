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
        Schema::create('bank_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')
                ->constrained('users')
                ->where('role', 'teacher')
                ->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajarans')
                ->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajarans')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soals');
    }
};
