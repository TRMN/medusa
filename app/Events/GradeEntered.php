<?php

namespace App\Models\Events;

use App\Models\User as User;
use Illuminate\Queue\SerializesModels;

class GradeEntered
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
