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
       Schema::create('places', function (Blueprint $table) {
          $table->uuid('id')->primary();
          $table->string('title');
          $table->string('slug');
          $table->uuid('user_id')->nullable(false);
          $table->uuid('category_id')->nullable(false);
          $table->text('description');
          $table->string('phone');
          $table->string('website');
          $table->string('tahun');
          $table->text('address');
          $table->string('longitude');
          $table->string('latitude');
          $table->timestamps();
    
          //relationship category
          $table->foreign('category_id')->references('id')->on('categories');
    
          //relationship user
          $table->foreign('user_id')->references('id')->on('users');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
