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
    Schema::create('application_statuses', function (Blueprint $table) {
      $table->foreignUuid('application_id')->constrained()->onDelete('CASCADE');
      $table->foreignUuid('status_id')->nullable()->constrained()->nullOnDelete();
      $table->foreignUuid('monthly_session_id')->constrained()->nullOnDelete();
      $table->text('comments')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('application_statuses');
  }
};
