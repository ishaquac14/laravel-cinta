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
        Schema::table('cctv_monitorings', function (Blueprint $table) {
            $table->string('posisi_name')->nullable()->after('lokasi_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cctv_monitorings', function (Blueprint $table) {
            $table->dropColumn('posis_name');
        });
    }
};
