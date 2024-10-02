<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            // Use varchar(20) for student_id since it matches the students table
            $table->string('student_id', 20); // Foreign key to students table

            $table->unsignedBigInteger('branch_id');  // Foreign key to branches table
            $table->unsignedBigInteger('course_id');  // Foreign key to courses table
            $table->date('scheduled_date');
            $table->string('status')->default('pending');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('student_id')->references('student_id')->on('enrollments')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}

