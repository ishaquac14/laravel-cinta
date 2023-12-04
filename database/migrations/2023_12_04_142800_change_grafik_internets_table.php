<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('grafik_internets', function (Blueprint $table) {
            $table->float('persen')->change();
    });
    
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grafik_internets', function (Blueprint $table) {
            $table->string('persen', 2)->change();
        });
    }
};
