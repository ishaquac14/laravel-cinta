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
        Schema::table('gacsirts', function (Blueprint $table) {
            // Ganti tipe data kolom 'nama_kolom' dari number ke varchar
            $table->date('date')->change();
            $table->integer('tincoming')->change();
            $table->integer('tcompleted')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gacsirts', function (Blueprint $table) {
            // Ganti tipe data kolom 'nama_kolom' dari number ke varchar
            $table->string('date')->change();
            $table->string('tincoming')->change();
            $table->string('tcompleted')->change();
        });
    }
};
