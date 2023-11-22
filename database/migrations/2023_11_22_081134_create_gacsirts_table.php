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
        Schema::create('gacsirts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('date'); 
            $table->string('tincoming')->nullable(); 
            $table->string('incoming')->nullable(); 
            $table->string('tcompleted')->nullable(); 
            $table->string('completed')->nullable(); 
            $table->string('status'); 
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('gacsirts');
    }
};