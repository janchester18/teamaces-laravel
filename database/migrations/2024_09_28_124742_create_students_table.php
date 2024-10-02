<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('student_id', 20)->unique(); // Unique Student ID from enrollment
            $table->string('first_name'); // First name of the student
            $table->string('last_name'); // Last name of the student
            $table->date('dob'); // Date of birth
            $table->string('address')->nullable(); // Optional address
            $table->string('phone_number')->nullable(); // Optional phone number
            $table->string('email')->unique(); // Email address
            $table->unsignedBigInteger('course_id'); // Foreign key for course
            $table->unsignedBigInteger('branch_id'); // Foreign key for branch
            $table->boolean('is_email_verified')->default(false); // Email verification status
            $table->boolean('is_approved')->default(false); // Approval status
            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraints (make sure to adjust the course_id and branch_id references if necessary)
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
