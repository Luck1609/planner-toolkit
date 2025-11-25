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
    Schema::create('meetings', function (Blueprint $table) {
      $table->uuid('id')->unique()->primary();
      $table->foreignUuid('monthly_session_id')->nullable()->constrained()->nullOnDelete();
      $table->string('title');
      $table->text('agenda')->nullable();
      $table->date('date');
      $table->time('time');
      $table->string('venue');
      $table->string('type');
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
    Schema::dropIfExists('meetings');
  }
};
