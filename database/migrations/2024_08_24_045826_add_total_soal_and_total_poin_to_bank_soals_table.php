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
        Schema::table('bank_soals', function (Blueprint $table) {
            $table->integer('total_soal')->default(0)->after('tahun_ajaran_id');
            $table->integer('total_poin')->default(0)->after('total_soal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_soals', function (Blueprint $table) {
            $table->dropColumn('total_soal');
            $table->dropColumn('total_poin');
        });
    }
};
