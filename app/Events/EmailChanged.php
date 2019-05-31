<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class EmailChanged
{
    use SerializesModels;

    public $old_email;

    public $new_email;

    /**
     * EmailChanged constructor.
     *
     * @param string $old
     * @param string $new
     */
    public function __construct(string $old, string $new)
    {
        $this->old_email = $old;
        $this->new_email = $new;
    }
}
