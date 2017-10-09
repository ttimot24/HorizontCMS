<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PluginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizontcms:plugin {--install} {--uninstall} {--activate} {--deactivate} {--download} {--remove} {plugin} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and ectivate plugin.';

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

        $selectedPlugin = $this->argument('plugin');

        echo PHP_EOL."Selected plugin: ".$selectedPlugin.PHP_EOL.PHP_EOL;
        
        if($this->option('download')){
            $this->download($selectedPlugin);
        }

        if($this->option('install')){
            $this->install($selectedPlugin);
        }

        if($this->option('activate')){
            $this->activate($selectedPlugin);
        }

        if($this->option('deactivate')){
            $this->deactivate($selectedPlugin);
        }

        if($this->option('uninstall')){
            $this->uninstall($selectedPlugin);
        }

        if($this->option('remove')){
            $this->remove($selectedPlugin);
        }

    }



    private function download($selectedPlugin){
        
        echo "Download...".PHP_EOL;
        throw new \Exception("This function is not supported yet!");
    }

    private function remove($selectedPlugin){
        
        echo "Remove...".PHP_EOL;
        throw new \Exception("This function is not supported yet!");
    }


    private function install($selectedPlugin){
        
        echo "Install...".PHP_EOL;
        throw new \Exception("This function is not supported yet!");
    }


    private function uninstall($selectedPlugin){
        
        echo "Uninstall...".PHP_EOL;
        throw new \Exception("This function is not supported yet!");
    }



    private function activate($selectedPlugin){
            
        echo "Activate...".PHP_EOL;

        if(\App\Model\Plugin::where('root_dir',$selectedPlugin)->update(['active' => 1])){
            echo "Plugin successfully activated!".PHP_EOL;
        }else{
            echo "Could not activate the plugin!".PHP_EOL;
        }

    
    }


    private function deactivate($selectedPlugin){
        
        echo "Deactivate...".PHP_EOL;


        if(\App\Model\Plugin::where('root_dir',$selectedPlugin)->update(['active' => 0])){
            echo "Plugin successfully deactivated!".PHP_EOL;
        }else{
            echo "Could not deactivate the plugin!".PHP_EOL;
        }


    }


}