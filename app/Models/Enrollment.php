<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    // Primary key as student ID
    protected $primaryKey = 'student_id';
    public $incrementing = false; // Non-incrementing ID

    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'address',
        'phone_number',
        'email',
        'course',
        'is_email_verified',
        'is_approved',
    ];

    protected $casts = [
        'is_email_verified' => 'boolean',
        'is_approved' => 'boolean',
    ];

    // Automatically generate the student_id based on the current year and dob
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            // Get the last two digits of the current year
            $currentYear = date('y');

            // Generate a 5-digit random number
            $randomNumber = sprintf('%05d', mt_rand(0, 99999)); // Ensures the number is always 5 digits long

            // Generate the student ID: last two digits of the year + '-' + 5-digit random number
            $model->student_id = $currentYear . '-' . $randomNumber;

            // Ensure the student ID is unique
            while (self::where('student_id', $model->student_id)->exists()) {
                $randomNumber = sprintf('%05d', mt_rand(0, 99999)); // Generate a new random number
                $model->student_id = $currentYear . '-' . $randomNumber;
            }
        });
    }

}
