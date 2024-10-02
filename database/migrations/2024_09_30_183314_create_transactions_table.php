<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            // Auto-incrementing primary key (transaction ID)
            $table->id();

            // Foreign key to the student's ID (stored as a VARCHAR due to custom format)
            $table->string('student_id', 20);

            // Foreign key references to the branch and course tables
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('course_id');

            // Price field
            $table->decimal('price', 10, 2); // Adjust precision as needed

            // Staff ID of the person who processed the transaction
            $table->unsignedBigInteger('staff_id');

            // Status field with a default value of 'paid'
            $table->string('status', 20)->default('paid');

            // Timestamps for created_at and updated_at
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
