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
    Schema::create('sms_notifications', function (Blueprint $table) {
      $table->uuid('id')->unique()->primary();
      $table->json('contacts');
      $table->string('type');
      $table->longText('message');
      $table->foreignUuid('user_id')->constrained()->nullOnDelete();
      $table->integer('units_used');
      $table->boolean('status')->default(false); // Processed on not?
      $table->boolean('bulk')->default(false); // If it is bulk sms data should be an array
      $table->dateTime('sent_date')->nullable(); // Processed date
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
    Schema::dropIfExists('sms_notifications');
  }
};
