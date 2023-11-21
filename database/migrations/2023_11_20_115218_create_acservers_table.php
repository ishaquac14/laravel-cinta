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
        Schema::create('acservers', function (Blueprint $table) {
            $table->id();
            $table->string('kondisi');
            $table->string('ac-01_suhu')->nullable(); 
            $table->string('ac-02_suhu')->nullable(); 
            $table->string('ac-03_suhu')->nullable(); 
            $table->string('ac-04_suhu')->nullable();  
            $table->string('note')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acservers');
    }
};
