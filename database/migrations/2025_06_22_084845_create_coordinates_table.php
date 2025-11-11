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
    Schema::create('coordinates', function (Blueprint $table) {
      $table->uuid('id')->unique()->primary();
      $table->decimal('longitude', 10, 7);
      $table->decimal('latitude', 10, 7);
      $table->foreignUuid('application_id')->constrained()->onDelete('CASCADE');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('coordinates');
  }
};
