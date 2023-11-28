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
        Schema::table('mointernets', function (Blueprint $table) {
            // Tambahkan kolom baru ke tabel
            $table->unsignedInteger('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mointernets', function (Blueprint $table) {
            // Jika Anda perlu rollback, hapus kolom yang telah ditambahkan
            $table->dropColumn('duration');
        });
    }
};
