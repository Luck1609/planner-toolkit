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
    Schema::create('backups', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('model_name');
      $table->text('data');
      $table->boolean('updates')->default(false); // where data was updated or new entry
      $table->boolean('deleted')->default(false); // where data has been deleted
      $table->boolean('processed')->default(false); // true if synced with online server
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('backups');
  }
};
