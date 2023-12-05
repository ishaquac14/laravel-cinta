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
            $table->string('suhu_ruangan');
            $table->string('follow_up')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('acservers', function (Blueprint $table) {
            $table->dropColumn('suhu_ruangan');
            $table->dropColumn('follow_up');
        });
    }
};
