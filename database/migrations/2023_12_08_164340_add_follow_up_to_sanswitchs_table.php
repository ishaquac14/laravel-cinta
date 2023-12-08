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
        Schema::table('sanswitchs', function (Blueprint $table) {
            $table->string('follow_up')->nullable();
        });
    }

    
    public function down(): void
    {
        Schema::table('sanswitchs', function (Blueprint $table) {
            $table->dropColumn('follow_up');
        });
    }
};
