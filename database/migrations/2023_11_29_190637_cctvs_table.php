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
        Schema::create('cctvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');

            for ($i = 1; $i <= 3; $i++) {
                $columnName = "cam{$i}";
                $table->string($columnName);
            }
            
            for ($i = 1; $i <= 3; $i++) {
                $columnName = "kondisi_cam{$i}";
                $table->string($columnName)->nullable();
            }

            $table->string('note')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctvs');
    }
};