<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sanswitchs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('powerstatus');
            $table->string('notif');
            
            // Tambahkan kolom 'hdd1' hingga 'hdd19' untuk storage3
            for ($i = 0; $i <= 3; $i++) {
                $columnName = "port{$i}";
                $table->string($columnName);
            }
    
            // Kolom host4 dan storage4
            $table->string('powerstatus_');
            $table->string('notif_');
            
            // Tambahkan kembali kolom 'hdd1' hingga 'hdd10' untuk storage4
            for ($i = 0; $i <= 4; $i++) {
                $columnName = "port_{$i}";
                $table->string($columnName);
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
        Schema::dropIfExists('sanswitchs');
    }
};

