<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $keyType = 'string'; // Ensure the key type is set to string
    public $incrementing = false;   // Disable auto-incrementing

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

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_courses')
            ->withPivot('is_package', 'has_permit', 'is_approved', 'status')
            ->withTimestamps();
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
