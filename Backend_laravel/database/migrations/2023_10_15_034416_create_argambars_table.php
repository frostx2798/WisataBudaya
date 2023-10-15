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
       Schema::create('argambars', function (Blueprint $table) {
          $table->uuid('id')->primary();
          $table->uuid('user_Id')->nullable(false);
          $table->string('judul');
          $table->string('image');
          $table->text('konten');
          $table->timestamps();
    
         //relationship user
        $table->foreign('user_id')->references('id')->on('users');
       });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Imagear');
    }
};
