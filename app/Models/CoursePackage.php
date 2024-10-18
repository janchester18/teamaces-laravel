<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePackage extends Model
{
    use HasFactory;

    protected $table = 'course_package'; // Specify the table name if it's not the plural of the model name

    protected $fillable = ['course_id', 'package_id']; // Define fillable columns

    // Define the relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
