<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSchedulesTableForeignKey extends Migration
{
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Drop the old foreign key
            $table->dropForeign(['student_id']);

            // Add the new foreign key pointing to students table
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Drop the new foreign key on rollback
            $table->dropForeign(['student_id']);

            // Restore the old foreign key pointing to enrollments table
            $table->foreign('student_id')->references('student_id')->on('enrollments')->onDelete('cascade');
        });
    }
}
