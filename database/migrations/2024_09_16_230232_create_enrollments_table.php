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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob'); // Date of birth
            $table->string('address');
            $table->string('phone_number');
            $table->string('email')->unique(); // Unique email with verification
            $table->string('course');
            $table->boolean('is_email_verified')->default(false); // Email verification status
            $table->boolean('is_approved')->default(false); // Admin approval status after payment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
