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
        Schema::table('soals', function (Blueprint $table) {
            $table->enum('jenis_soal', ['pg', 'essay'])->default('pg')->after('jawaban_benar');

            $table->text('jawaban_essay')->nullable()->after('jawaban_benar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->dropColumn('jenis_soal');
            $table->dropColumn('jawaban_essay');
        });
    }
};
