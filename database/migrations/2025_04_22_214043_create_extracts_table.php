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
    Schema::create('extracts', function (Blueprint $table) {
      $table->uuid('id')->unique()->primary();
      $table->string('title', 10);
      $table->string('firstname');
      $table->string('lastname');

      $table->foreignUuid('locality_id')->constrained()->nullOnDelete();
      $table->foreignUuid('sector_id')->constrained()->nullOnDelete();

      $table->string('block');
      $table->string('plot_number');
      $table->string('allocation_date');
      $table->string('registration_date');
      $table->string('phone_number');
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
    Schema::dropIfExists('extracts');
  }
};
