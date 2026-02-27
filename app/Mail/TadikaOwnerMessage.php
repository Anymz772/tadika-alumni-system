<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TadikaOwnerMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $messageBody;

    /**
     * Create a new message instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->subjectLine = $data['subject'] ?? '';
        $this->messageBody = $data['message'] ?? '';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.tadika_owner_message')
                    ->with([
                        'messageBody' => $this->messageBody,
                    ]);
    }
}
