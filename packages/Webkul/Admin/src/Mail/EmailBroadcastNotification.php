<?php

namespace Webkul\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBroadcastNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param string $emailSubject
     * @param string $emailContent
     * @param string $recipientEmail
     * @param string $recipientName
     */
    public function __construct(
        public string $emailSubject,
        public string $emailContent,
        public string $recipientEmail,
        public string $recipientName = ''
    ) {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->recipientEmail)
            ->subject($this->emailSubject)
            ->view('admin::emails.email-broadcast')
            ->with([
                'emailSubject' => $this->emailSubject,
                'content' => $this->emailContent,
                'recipientName' => $this->recipientName,
            ]);
    }
}
