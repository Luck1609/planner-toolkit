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
    Schema::create('deferred_records', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->longText('comments');
      $table->foreignUuid('application_id')->constrained()->onDelete('CASCADE');
      $table->date('deferred_on');
      $table->foreignUuid('monthly_session_id')->constrained()->nullOnDelete();
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
    Schema::dropIfExists('deferred_records');
  }
};
