<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); // Automatically creates an 'id' column as the primary key
            $table->string('name'); // Name of the course
            $table->text('description'); // Description of the course
            $table->integer('number_of_sessions'); // Number of sessions
            $table->integer('hours_per_session'); // Number of hours per session
            $table->decimal('price', 8, 2); // Price of the course (up to 8 digits, 2 decimal points)
            $table->timestamps(); // Creates 'created_at' and 'updated_at' columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
