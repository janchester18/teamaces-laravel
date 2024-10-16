<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleAdjustmentRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('schedule_adjustment_requests', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade'); // Foreign key referencing schedules table
            $table->dateTime('new_scheduled_date'); // New scheduled start date and time
            $table->dateTime('new_schedule_finish'); // Calculated finish time
            $table->string('status')->default('pending'); // Status of the request
            $table->text('reason')->nullable(); // Reason for rejection, nullable
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_adjustment_requests');
    }
}
