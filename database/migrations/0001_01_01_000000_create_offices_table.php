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
    Schema::create('offices', function (Blueprint $table) {
      $table->uuid('id')->unique()->primary();
      $table->foreignUuid('region_id')->references('id')->on('regions')->nullOnDelete();
      $table->foreignUuid('district_id')->references('id')->on('districts')->nullOnDelete();
      $table->string('name');
      $table->string('initials');
      $table->string('address')->nullable();
      $table->integer('shelves')->nullable();
      $table->string('email')->unique()->nullable();
      $table->integer('sms_balance')->nullable();
      $table->integer('server_id')->nullable(); // office id on server
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('offices');
  }
};
