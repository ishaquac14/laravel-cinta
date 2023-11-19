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
        Schema::create('physicals', function (Blueprint $table) {
            $table->id();
            $table->string('host3');
            $table->string('storage3');
            
            // Tambahkan kolom 'hdd1' hingga 'hdd19' untuk storage3
            for ($i = 1; $i <= 19; $i++) {
                $columnName = "hdd{$i}";
                $table->string($columnName);
            }
    
            // Kolom host4 dan storage4
            $table->string('host4');
            $table->string('storage4');
            
            // Tambahkan kembali kolom 'hdd1' hingga 'hdd10' untuk storage4
            for ($i = 1; $i <= 10; $i++) {
                $columnName = "hdd_{$i}";
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
        Schema::dropIfExists('physicals');
    }
};

