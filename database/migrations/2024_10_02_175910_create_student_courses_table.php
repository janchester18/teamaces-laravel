<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_courses', function (Blueprint $table) {
            $table->id(); // Primary key

            // Foreign key references
            $table->string('student_id', 20); // Match the data type of `students.id`
            $table->unsignedBigInteger('course_id'); // Assuming `courses.id` is an unsignedBigInteger

            // Additional columns
            $table->boolean('is_package')->default(false); // Determines if it's a package enrollment
            $table->boolean('has_permit')->default(false); // Determines if a permit is issued
            $table->boolean('is_approved')->default(false); // Determines if the enrollment is approved
            $table->string('status')->default('pending'); // Enrollment status (e.g., pending, active, completed, etc.)

            // Foreign key constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade'); // Use matching type
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

            $table->timestamps(); // Created at and Updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_courses');
    }
}
