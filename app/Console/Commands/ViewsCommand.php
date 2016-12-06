<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ViewsCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'views:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear views folder';

    /**
     * The file system instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->files = new \Illuminate\Filesystem\Filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        foreach ($this->files->files(storage_path() . '/views') as $file) {
            $this->files->delete($file);
        }

        $this->info('Views deleted from cache');
    }
}
