<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'inquiries';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'phone_number', // Add this
        'message',
        'status',
    ];

    // Optional: Define constants for the possible status values
    const STATUS_PENDING = 'pending';
    const STATUS_RESOLVED = 'resolved';

    // Additional logic or relationships can go here
}
