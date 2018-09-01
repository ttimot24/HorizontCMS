<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizontcms:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prints the application version.';

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
        $this->info(PHP_EOL.\Config::get('app.name')." - ".\Config::get('horizontcms.version').PHP_EOL);
    }
}