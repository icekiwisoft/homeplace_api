<?php

namespace App\Mail;

namespace App\Mail;

use App\Models\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscription extends Mailable
{
    use Queueable, SerializesModels;

    public $mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Newsletter $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Newsletter Subscription Confirmation')
            ->view('emails.newsletter_confirmation');
    }
}
