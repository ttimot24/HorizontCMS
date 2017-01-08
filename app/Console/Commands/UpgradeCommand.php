<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpgradeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizontcms:upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrades the system core.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

}