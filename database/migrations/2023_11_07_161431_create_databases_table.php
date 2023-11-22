<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('databases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('asiic'); 
            $table->string('avicenna'); 
            $table->string('broadcast'); 
            $table->string('cubic_pro'); 
            $table->string('gary'); 
            $table->string('iatf'); 
            $table->string('lobby'); 
            $table->string('maps_body'); 
            $table->string('maps_unit'); 
            $table->string('prisma'); 
            $table->string('risna'); 
            $table->string('sikola'); 
            $table->string('sinta'); 
            $table->string('solid'); 
            $table->string('cubic_pro_legacy'); 
            $table->string('sikola_legacy');  
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('databases');
    }
}

