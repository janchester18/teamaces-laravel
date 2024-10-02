<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = ['name', 'price', 'is_active'];

    // Optionally, add any relationships or custom methods as needed.
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_package')
            ->withTimestamps();
    }
}
