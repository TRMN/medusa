<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mcamReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * An array of MCAM recipients for the previous month.
     *
     * @var array
     */
    public $mcamReport;

    /**
     * Create a new message instance.
     *
     * @param array $mcamReport
     *
     * @return void
     */
    public function __construct(array $mcamReport)
    {
        $this->mcamReport = $mcamReport;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('awards.from.address'), config('awards.from.name'))
            ->subject(config('awards.MCAM-notification.subject'))->markdown('emails.mcamReport');
    }
}
