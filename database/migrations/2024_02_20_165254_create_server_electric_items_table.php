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
        Schema::create('c_server_electric_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_electric_id')->constrained('c_server_electrics');
            $table->string('type');
            $table->string('item');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_electric_items');
    }
};
