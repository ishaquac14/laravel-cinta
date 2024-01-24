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
        Schema::table('csdatabases', function (Blueprint $table) {
            $table->string('devita')->after('sikola_legacy');
            $table->string('cinta')->after('devita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('csdatabases', function (Blueprint $table) {
            $table->dropColumn('devita');
            $table->dropColumn('cinta');
        });
    }
};
