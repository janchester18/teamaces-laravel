<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleAdjustmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'new_scheduled_date',
        'new_schedule_finish',
        'status',
        'reason',
    ];

        // Define the relationship to the Schedule model
        public function schedule()
        {
            return $this->belongsTo(Schedule::class);
        }
}
