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
        Schema::create('cctv_monitorings', function (Blueprint $table) {
            $table->id();
            $table->integer('cctv_id');
            $table->string('id_cctv');
            $table->string('building_name');
            $table->string('lokasi_name');
            $table->string('status');
            $table->string('condition')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctv_monitorings');
    }
};
