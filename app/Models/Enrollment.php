<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'address',
        'phone_number',
        'email',
        'course_id',
        'branch_id',
        'package_id',  // Add this line
        'is_email_verified',
        'is_approved',
    ];

    protected $casts = [
        'is_email_verified' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');  // Define relationship with Package
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $currentYear = date('y');
            $randomNumber = sprintf('%05d', mt_rand(0, 99999));
            $model->id = $currentYear . '-' . $randomNumber;

            while (self::where('id', $model->id)->exists()) {
                $randomNumber = sprintf('%05d', mt_rand(0, 99999));
                $model->id = $currentYear . '-' . $randomNumber;
            }
        });
    }
}
