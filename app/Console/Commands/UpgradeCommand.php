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
    protected $signature = 'hcms:upgrade';

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



    public function handle(){
 
        $workspace = storage_path().DIRECTORY_SEPARATOR."framework".DIRECTORY_SEPARATOR."upgrade";
        $url = \Config::get('horizontcms.sattelite_url')."/updates";

        $update = new \VisualAppeal\AutoUpdate($workspace.DIRECTORY_SEPARATOR.'temp', getcwd() , 60);
        $update->setCurrentVersion(\App\Model\SystemUpgrade::getCurrentVersion()->version);
        $update->setUpdateUrl($url); //Replace with your server update directory
        // Optional:
        $update->addLogHandler(new \Monolog\Handler\StreamHandler($workspace . '/update.log'));
        $update->setCache(new \Desarrolla2\Cache\Adapter\File($workspace . '/cache'), 3600);
        //Check for a new update


        if ($update->checkUpdate() === false)
            die('Could not check for updates! See log file for details.');
        if ($update->newVersionAvailable()) {
            //Install new update
            echo 'New Version: ' . $update->getLatestVersion() . '<br>';
            echo 'Installing Updates: <br>';
            echo '<pre>';
            var_dump(array_map(function($version) {
                return (string) $version;
            }, $update->getVersionsToUpdate()));
            echo '</pre>';
            // This call will only simulate an update.
            // Set the first argument (simulate) to "false" to install the update
            // i.e. $update->update(false);
            $result = $update->update(false);
            if ($result === true) {
                echo 'Update successful<br>';
                $sys_upgrade = new \App\Model\SystemUpgrade();
                $sys_upgrade->version = $update->getLatestVersion();
                $sys_upgrade->nickname = "Upgrade";
                $sys_upgrade->importance = "important";
                $sys_upgrade->description = "It was a successful update!";
                $sys_upgrade->save();
            } else {
                echo 'Update failed: ' . $result . '!<br>';
                if ($result = AutoUpdate::ERROR_SIMULATE) {
                    echo '<pre>';
                    var_dump($update->getSimulationResults());
                    echo '</pre>';
                }
            }
        } else {
            echo 'Current Version is up to date<br>';
        }
        echo 'Log:<br>';
        echo nl2br(file_get_contents($workspace. '/update.log'));


    }


}