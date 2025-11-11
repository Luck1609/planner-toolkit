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
    Schema::create('minutes', function (Blueprint $table) {
      $table->uuid('id');
      $table->string('title')->nullable();
      $table->string('venue')->nullable();
      $table->date('date')->nullable();
      $table->time('time')->nullable();
      $table->json('participants')->nullable();
      $table->json('attendees')->nullable();
      $table->json('absentees')->nullable();
      $table->foreignUuid('meeting_id')->constrained()->onDelete('CASCADE');
      $table->json('content')->nullable();
      $table->json('recorded_by')->nullable(); // Name, role, department
      $table->json('approved_by')->nullable(); // Name, role, department
      $table->enum('status', ['draft', 'published'])->default('draft');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('minutes');
  }
};
