<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

        // Define the table associated with the model (optional if it follows Laravel's naming convention)
     protected $table = 'branches';

        // Specify the fields that can be mass-assigned
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
    ];
}
