<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdTypeInStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Change the id column type to match student_id
            $table->string('id', 20)->change(); // Assuming student_id is varchar(20)
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // Optionally revert the change to the original type
            $table->bigIncrements('id')->change(); // Revert to the original type if necessary
        });
    }
}
