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
        Schema::create('jawaban_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_ujian_id')
                ->constrained('hasil_ujians')
                ->onDelete('cascade');
            $table->foreignId('soal_id')
                ->constrained('soals')
                ->onDelete('cascade');
            $table->enum('jawaban', ['A', 'B', 'C', 'D']);
            $table->boolean('status_benar')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
    }
};
