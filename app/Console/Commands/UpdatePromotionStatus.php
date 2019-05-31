<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdatePromotionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:updps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update every members promotion eligibility status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (User::activeUsers() as $member) {
            $member->promotionStatus = $member->isPromotable();
            $member->save();
        }
    }
}
