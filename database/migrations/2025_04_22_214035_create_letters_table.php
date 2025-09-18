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
    Schema::create('letters', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('reference')->nullable();
      $table->string('organisation')->nullable();
      $table->date('date')->nullable();
      $table->string('email')->nullable();
      $table->text('content')->nullable();
      $table->enum('state', ['outgoing', 'incoming'])->nullable();
      $table->enum('status', ['draft', 'published'])->default('draft');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('letters');
  }
};
