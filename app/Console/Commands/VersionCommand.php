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
    protected $signature = 'hcms:version {--no-banner : Do not display the banner}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prints the application version.';

    private $banner = 
  ",--.  ,--.              ,--.                        ,--.   ,-----.,--.   ,--. ,---.   
|  '--'  | ,---. ,--.--.`--',-----. ,---. ,--,--, ,-'  '-.'  .--./|   `.'   |'   .-'  
|  .--.  || .-. ||  .--',--.`-.  / | .-. ||      \'-.  .-'|  |    |  |'.'|  |`.  `-.  
|  |  |  |' '-' '|  |   |  | /  `-.' '-' '|  ||  |  |  |  '  '--'\|  |   |  |.-'    | 
`--'  `--' `---' `--'   `--'`-----' `---' `--''--'  `--'   `-----'`--'   `--'`-----'  
                                                                                    
app.name - {app.version}
Closer to the WEB";

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
        if(!$this->option('no-banner')){
            $this->info(PHP_EOL.str_Replace("app.name",\Config::get('app.name'),str_replace("{app.version}",\Config::get('horizontcms.version'), $this->banner)).PHP_EOL);
        }else {
            $this->info(PHP_EOL.\Config::get('app.name')." - ".\Config::get('horizontcms.version').PHP_EOL);
        }
    }
}