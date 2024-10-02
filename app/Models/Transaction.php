<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'branch_id',
        'course_id',
        'package_id', // Add package_id to the fillable array
        'price',
        'staff_id',
        'status',
    ];

    // Define any relationships if needed
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id'); // Define the relationship to the Package model
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
