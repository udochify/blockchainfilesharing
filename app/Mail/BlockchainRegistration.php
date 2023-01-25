<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BlockchainRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    private $key;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($key)
    {
        $this->username = auth()->user()->name;
        $this->key = $key;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Blockchain Registration Key',
            from: new Address('nccfutoblockchain@dev.com', 'Dev Team')
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.blockchain_registration.index',
            with: [
                'website' => env('APP_URL'),
                'key' => $this->key
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
