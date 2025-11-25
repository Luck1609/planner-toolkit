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
        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('phone_number');
            $table->uuidMorphs('contact');
            // $table->uuid('contactable_id');
            // $table->string('contactable_type');
            // $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            // $table->foreignUuid('office_id')->nullable()->references('id')->on('offices')->onDelete('cascade');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
