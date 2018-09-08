<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Settings;
use \VisualAppeal\AutoUpdate;
use \Jackiedo\LogReader\Facades\LogReader;

class SettingsController extends Controller{

    public function before(){
        if(!file_exists("storage/images/logos")){
          \File::makeDirectory("storage/images/logos", $mode = 0777, true, true);
        }
    }


    public function saveSettings(){

        if($this->request->isMethod('POST')){

            foreach($this->request->all() as $key => $value){
              Settings::where('setting', '=', $key)->update(['value' => $value]);
            }

            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
        }

    }

 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = 'index'){

                $panels = [
                    ['name' => trans('settings.website'),'link' => 'admin/settings/website','icon' => 'fa fa-globe'],
                    ['name' => trans('settings.admin_area'),'link' => 'admin/settings/adminarea','icon' => 'fa fa-desktop'],
                    ['name' => trans('settings.update_center'),'link' => 'admin/settings/updatecenter','icon' => 'fa fa-arrow-circle-o-up'],
                    ['name' => trans('settings.server'),'link' => 'admin/settings/server','icon' => 'fa fa-server'],
                    ['name' => trans('settings.email'),'link' => 'admin/settings/email','icon' => 'fa fa-envelope'],
                    ['name' => trans('settings.social_media'),'link' => 'admin/settings/socialmedia','icon' => 'fa fa-thumbs-o-up'],
                    ['name' => trans('Log'),'link' => 'admin/settings/log', 'icon' => 'fa fa-bug'],
                    ['name' => trans('settings.database'),'link' => 'admin/settings/database','icon' => 'fa fa-database'],
                    ['name' => trans('settings.spread'),'link' => 'admin/settings/spread','icon' => 'fa fa-paper-plane'],
                    ['name' => trans('settings.uninstall'),'link' => 'admin/settings/uninstall','icon' => 'fa fa-exclamation-triangle'],

                    ];



        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/index',[
                                                        'panels' => $panels,
                                                    ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function website($slug){


        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/website',[
                                                        'settings' => $this->request->settings,
                                                        'available_logos' => array_slice(scandir("storage/images/logos"),2),
                                                    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminarea($slug){


        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/adminarea',[
                                                        'settings' => $this->request->settings,
                                                        'languages' => ['en'=>'English','hu'=>'Magyar'],
                                                        'available_logos' => array_slice(scandir("storage/images/logos"),2),
                                                    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatecenter($slug){

        \App\Model\SystemUpgrade::checkUpgrade();

        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/updatecenter',[
                                                        'current_version' => \App\Model\SystemUpgrade::getCurrentVersion(),
                                                        'latest_version' => \App\Model\SystemUpgrade::getLatestVersion(),
                                                        'available_list' => array_reverse(\App\Model\SystemUpgrade::getAllAvailable()),
                                                        'upgrade_list' => \App\Model\SystemUpgrade::getUpgrades(),
                                                        'installed_version' => \App\Model\SystemUpgrade::getCore(),

                                                    ]);
    }


    public function sysUpgrade(){
   
        $echo = array();

        $workspace = storage_path("framework/upgrade");
        $url = \Config::get('horizontcms.sattelite_url')."/updates";


        $update = new AutoUpdate($workspace.'/temp', public_path() , 60);
        $update->setCurrentVersion(\App\Model\SystemUpgrade::getCurrentVersion()->version);
        $update->setUpdateUrl($url); //Replace with your server update directory
        // Optional:
        $update->addLogHandler(new \Monolog\Handler\StreamHandler($workspace . '/update.log'));
        $update->setCache(new \Desarrolla2\Cache\Adapter\File($workspace . '/cache'), 3600);
        //Check for a new update


        if ($update->checkUpdate() === false){
            $echo[] = 'Could not check for updates! See log file for details.';
        } else{ 
        if ($update->newVersionAvailable()) {
            //Install new update
            $echo[] =  'New Version: ' . $update->getLatestVersion() . '<br>';
            $echo[] =  'Installing Updates: <br>';
            $echo[] =  '<pre>';
            $echo[] = print_r(array_map(function($version) {
              		   return (string) $version;
            		}, $update->getVersionsToUpdate()),true);
            $echo[] =  '</pre>';
            // This call will only simulate an update.
            // Set the first argument (simulate) to "false" to install the update
            // i.e. $update->update(false);
            $result = $update->update(false);
            if ($result === true) {
                $echo[] = 'Update successful<br>';
                $sys_upgrade = new \App\Model\SystemUpgrade();
                $sys_upgrade->version = $update->getLatestVersion();
                $sys_upgrade->nickname = "Upgrade";
                $sys_upgrade->importance = "important";
                $sys_upgrade->description = "It was a successful update!";
                $sys_upgrade->save();

                \Artisan::call("migrate",['--no-interaction' => '','--force' => true ]);
            } else {
                $echo[] = 'Update failed: ' . $result . '!<br>';
                if ($result = AutoUpdate::ERROR_SIMULATE) {
                    $echo[] = '<pre>';
                    $echo[] = print_r($update->getSimulationResults(),true);
                    $echo[] = '</pre>';
                }
            }
        } else {
            $echo[] = 'Current Version is up to date<br>';
        }
    }
        $echo[] = 'Log:<br>';
        $echo[] = nl2br(file_get_contents($workspace. '/update.log'));

               
        return $this->redirectToSelf()->with(['upgrade_console' => implode("<br>",$echo)]);
    }



    public function server(){
        $this->view->title("Server");
        return $this->view->render('settings/server',[
                                            'server' => $this->request->server(),
                                        ]);
    }


    public function database(){

    	$this->view->title(trans('settings.database'));
    	return $this->view->render('settings/database',[
    												'tables' => \DB::select('SHOW TABLES'),

    												]);
    }



    public function socialmedia(){


        if($this->request->isMethod('POST')){

            foreach($this->request->all() as $key => $value){
              Settings::where('setting', '=', "social_link_".$key)->update(['value' => $value]);
            }

            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
        }

        $this->view->title("SocialMedia");
        return $this->view->render('settings/socialmedia',[
                                        'all_socialmedia' => \SocialLink::all(),
                                        ]);
    }



    public function log($file){

        LogReader::setLogPath(dirname(\Config::get('app.log_path')));


        $files = collect(LogReader::getLogFilenameList());


        if($files->isNotEmpty()){

            $current_file = (isset($file) && $file!="" && $file!=NULL)? $file : basename($files->last());

            $entries = LogReader::filename($current_file)->get();

        }

       // dd($entries);

        $this->view->title("Log files");
        return $this->view->render('settings/log',[
                                        'all_files' => $files->reverse(),
                                        'entries' => $entries->reverse(),
                                        'entry_number' => $entries->count(),
                                        'all_file_entries' => LogReader::count(),
                                        'current_file' => $current_file,
                                        'max_files' => 15
                                        ]);

    }



    public function setlogo($image){
    	Settings::where('setting', '=', 'logo')->update(['value' => $image]);

    	return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
    }

    public function setAdminLogo($image){
    	Settings::where('setting', '=', 'admin_logo')->update(['value' => $image]);

    	return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
    }

    public function uploadlogo(){

    	foreach($this->request->up_file as $file){
    		$image = str_replace('images/logos/','',$file->store('images/logos'));
    	}

    	return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
    }


}
