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
    Schema::create('monthly_sessions', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->boolean('is_current')->default(true); // Set to false ones the session has elapsed
      $table->string('title');
      $table->boolean('finalized')->default(false); // Ones finalized, meeting can be scheduled, application status can be set
      $table->date('start_date');
      $table->date('end_date');
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
    Schema::dropIfExists('monthly_sessions');
  }
};
