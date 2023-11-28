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
            if (!Schema::hasColumn('mointernets', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->default(null);
    
                // Menambahkan foreign key constraint
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mointernets', function (Blueprint $table) {
            //
        });
    }
};
