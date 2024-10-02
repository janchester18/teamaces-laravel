<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEnrollmentsTableAddCourseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Drop the existing 'course' column
            $table->dropColumn('course');

            // Add the new 'course_id' column after 'email'
            $table->unsignedBigInteger('course_id')->after('email');

            // Add foreign key constraint for 'course_id'
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['course_id']); // Drop foreign key constraint

            // Drop the 'course_id' column
            $table->dropColumn('course_id');

            // Add back the 'course' column if needed
            $table->string('course')->after('email'); // Restore the course column after email
        });
    }
}
