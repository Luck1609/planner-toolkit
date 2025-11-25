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
    Schema::create('committees', function (Blueprint $table) {
      $table->uuid('id');
      $table->string('firstname');
      $table->string('lastname');
      $table->string('title');
      $table->string('contact');
      $table->string('email');
      $table->string('designation');
      $table->string('panel');
      $table->string('role');
      $table->boolean('status')->default(false);
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
    Schema::dropIfExists('committees');
  }
};
