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
    Schema::create('sectors', function (Blueprint $table) {
      $table->uuid('id')->unique()->primary();
      $table->foreignUuid('locality_id')->constrained('localities')->onDelete('CASCADE');
      $table->string('name');
      $table->string('initials');
      $table->json('blocks');
      $table->foreignUUid('deleted_by')->nullable()->references('id')->on('users')->nullOnDelete();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sectors');
  }
};
