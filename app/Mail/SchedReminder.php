<?php

namespace App\Mail;

use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SchedReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $schedule;

    /**
     * Create a new message instance.
     */
    public function __construct($student, $schedule)
    {
        $this->student = $student;
        $this->schedule = $schedule;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Driving Lesson Schedule Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'sched_reminder', // Your Markdown email template
            with: [
                'student' => $this->student,
                'schedule' => $this->schedule,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
