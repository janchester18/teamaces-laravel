<?php

namespace App\Mail;

use App\Models\Transaction;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $student;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student, Transaction $transaction)
    {
        $this->student = $student;
        $this->transaction = $transaction;
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->subject('Payment Update Notification')
                    ->view('emails.payment_updated'); // You can adjust the view name
    }
}
