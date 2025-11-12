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
    Schema::create('statuses', function (Blueprint $table) {
      $table->uuid('id')->unique()->primary();
      $table->string('name'); // Approved, Deferred, Refused Regularized
      $table->foreignUUid('user_id')->constrained()->nullOnDelete();
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
    Schema::dropIfExists('statuses');
  }
};
