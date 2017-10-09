<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizontcms:theme {theme}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the selected theme.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function handle(){

        echo PHP_EOL;
 
        $theme = $this->argument('theme');

        if(file_exists(base_path('themes'.DIRECTORY_SEPARATOR.$theme))){
            echo "Selected theme: ".$theme.PHP_EOL;

            $setting = \App\Model\Settings::where('setting','theme')->first();
            $setting->value = $theme;

            if($setting->update()){
                echo $theme." successfully set as current theme!".PHP_EOL;
            }else{
                echo "Could not set theme!";
            }

        }else{
            echo "The selected theme doesn't exists.";
        }


    }


}