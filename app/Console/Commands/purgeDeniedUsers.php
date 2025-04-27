<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
class purgeDeniedUsers extends Command
{
    use \App\Audit\MedusaAudit;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:purgeDeniedUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge denied users from the database';

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
        $users = User::where('registration_status', 'Denied')
            ->where('application_date', '<=', now()->subDays(30)->toDateString()) // Adjust the number of days as needed
            ->get();

        foreach ($users as $user) {
            $this->writeAuditTrail(
                'System User',
                'Denied User Purge',
                'User',
                $user->id,
                $user->toJson(),
                'User Purged'
            );

            $user->delete();
            $this->info("Deleted user: {$user->last_name}, {$user->first_name}");
        }
        $this->info('All denied users older than 30 days have been purged.');
    }
}
