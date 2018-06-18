<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class swpReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * An array of ESWP and OSWP recipients for the previous month
     *
     * @var array
     */

    public $swpReport;
    /**
     * Create a new message instance.
     *
     * @param array $swpReport
     *
     * @return void
     */
    public function __construct(array $swpReport)
    {
        $this->swpReport = $swpReport;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('awards.from.address'), config('awards.from.name'))
                    ->subject(config('awards.SWP-notification.subject'))->markdown('emails.swpReport');
    }
}
