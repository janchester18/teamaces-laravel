<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Mail\Mailable;

class BalanceReminder extends Mailable
{
    public $student;
    public $balance;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Student  $student
     * @param  string  $balance
     * @return void
     */
    public function __construct(Student $student, $balance)
    {
        $this->student = $student;

        // Remove any commas and convert the balance to a float
        $this->balance = (float)str_replace(',', '', $balance);  // Ensure it's a float
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Balance Reminder')
                    ->view('emails.balanceReminder')
                    ->with([
                        'studentName' => $this->student->first_name,
                        'balance' => $this->balance, // Pass balance to the email view
                    ]);
    }
}
