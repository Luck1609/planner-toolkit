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
    Schema::create('participants', function (Blueprint $table) {
      $table->uuid('id')->unique()->primary();
      $table->foreignUuid('meeting_id')->nullable()->constrained()->onDelete('CASCADE');
      $table->foreignUuid('participant_id')->nullable()->references('id')->on('committees')->nullOnDelete();
      $table->string('firstname');
      $table->string('lastname');
      $table->string('phone_number');
      $table->string('email')->nullable();
      $table->string('designation');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('participants');
  }
};
