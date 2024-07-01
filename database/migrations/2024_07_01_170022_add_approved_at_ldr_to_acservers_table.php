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
        Schema::table('acservers', function (Blueprint $table) {
            $table->timestamp('approved_at_ldr')->nullable()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acservers', function (Blueprint $table) {
            $table->dropColumn('approved_at_ldr');
        });
    }
};
