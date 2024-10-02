<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Check if 'id' is already the primary key
            if (Schema::hasColumn('students', 'id')) {
                // Drop the existing primary key if it exists
                $table->dropPrimary('id'); // Attempting to drop primary key
                $table->dropColumn('id');   // Remove the 'id' column
            }

            // Set 'student_id' as the primary key
            $table->primary('student_id');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // Re-add the 'id' column as a big integer with auto increment
            $table->bigIncrements('id')->first();

            // Optionally recreate the unique index for 'student_id' if necessary
            $table->unique('student_id', 'students_student_id_unique');
        });
    }
}
