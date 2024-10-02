<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'schedules';

    // Define the fillable properties for mass assignment
    protected $fillable = [
        'student_id',
        'branch_id',
        'course_id',
        'scheduled_date',
        'schedule_finish',
        'status',
    ];

    // Define relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
