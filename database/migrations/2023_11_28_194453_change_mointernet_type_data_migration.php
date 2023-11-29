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
            // Ganti tipe data kolom 'nama_kolom' dari number ke varchar
            $table->date('date')->change();
            $table->string('start_time')->nullable()->change();
            $table->string('end_time')->nullable()->change();
            $table->string('root_cause')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mointernets', function (Blueprint $table) {
            // Ganti tipe data kolom 'nama_kolom' dari number ke varchar
            $table->string('date')->change();
            $table->string('tincoming')->change();
            $table->string('tcompleted')->change();
        });
    }
};
