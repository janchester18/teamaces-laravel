<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'number_of_sessions',
        'hours_per_session',
        'price',
        'acronym', // Add this line
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_courses')
            ->withPivot('is_package', 'has_permit', 'is_approved', 'status')
            ->withTimestamps();
    }
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'course_package')
            ->withTimestamps();
    }
}
