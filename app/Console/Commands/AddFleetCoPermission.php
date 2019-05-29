<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Chapter;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class AddFleetCoPermission extends Command
{
    use \App\Models\Audit\MedusaAudit;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'user:addFleetCoPerms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add fleet CO permissions to a user';

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
        $user = User::where('member_id', '=', $this->argument('member_id'))->first();

        $fleet = Chapter::where('chapter_type', '=', 'fleet')->where('hull_number', '=', $this->argument('fleet'))->first();

        $user->assignCoPerms();

        $user->duty_roster = $fleet->id;

        $this->writeAuditTrail(
            'system user',
            'update',
            'users',
            (string) $user->_id,
            $user->toJson(),
            'AddFleetCoPermission'
        );

        $user->save();

        //$user->updatePerms([strtoupper($this->argument('perm'))]);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['member_id', InputArgument::REQUIRED, 'The user\'s TRMN number'],
            ['fleet', InputArgument::REQUIRED, 'Which Fleet they are the CO of'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
