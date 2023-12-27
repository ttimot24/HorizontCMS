<?php

namespace App\Controllers;

use App\Libs\Controller;

class UpgradeController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\Codedge\Updater\UpdaterManager $updater)
    {

        if($updater->source()->isNewVersionAvailable()) {

            // Get the current installed version
            echo $updater->source()->getVersionInstalled();
    
            // Get the new version available
            $versionAvailable = $updater->source()->getVersionAvailable();
    
            // Create a release
            $release = $updater->source()->fetch($versionAvailable);
    
            // Run the update process
            $updater->source()->update($release);
    
        } else {
            echo "No new version available.";
        }
        
    }

 
}
