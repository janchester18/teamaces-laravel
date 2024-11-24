<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Use Authenticatable for login
use Illuminate\Database\Eloquent\Model;

class Student extends Authenticatable
{
    use HasFactory;

    // Ensure the key type is set to string for UUID or other non-incrementing keys
    protected $keyType = 'string';
    public $incrementing = false;   // Disable auto-incrementing for the ID

    // Mass-assignable attributes
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'dob',
        'address',
        'phone_number',
        'email',
        'course_id',
        'branch_id',
        'is_email_verified',
        'is_approved',
    ];

    // Relationship to the Course model using the student_courses pivot table
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_courses')
            ->withPivot('is_package', 'has_permit', 'is_approved', 'status')
            ->withTimestamps();
    }

    // Relationship to the Schedule model (one-to-many)
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Optionally, you can add accessors or mutators if needed for your fields
    public function studentCourses()
    {
        return $this->hasMany(StudentCourse::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

