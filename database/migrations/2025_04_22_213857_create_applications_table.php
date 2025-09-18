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
    Schema::create('applications', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('user_id')->constrained();
      $table->string('application_num'); // application number for the given year
      $table->string('session_num');
      $table->string('dev_permit_num')->nullable();
      $table->string('permit_num')->nullable();
      $table->string('title');
      $table->string('firstname');
      $table->string('lastname');
      $table->string('contact');
      $table->foreignUuid('locality_id')->constrained();
      $table->foreignUuid('sector_id')->constrained();
      $table->foreignUuid('monthly_session_id')->constrained();
      $table->string('block');
      $table->string('plot_number');
      $table->integer('shelf')->nullable();
      $table->string('type');
      $table->string('address')->nullable();
      $table->string('house_no');

    //   $table->boolean('processed')->default(false);
      // $table->boolean('approved')->default(false);
      // $table->boolean('deferred')->default(false);
      // $table->boolean('refused')->default(false);
      // $table->boolean('regularized')->default(false);
      // $table->longText('decision')->nullable();


      $table->integer('height')->default(1);
      $table->longText('scanned_app_documents')->nullable();
      $table->longText('description')->nullable();
      $table->boolean('processed')->default(false); // If application is successfully recieved
      $table->boolean('existing')->default(false); // If building already exist [falls under regularization]
      $table->json('use');
      $table->date('approved_on')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('applications');
  }
};
