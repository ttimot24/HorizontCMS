<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Settings;

class SettingsController extends Controller{
 

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
                    ['name' => trans('settings.backup_database'),'link' => 'admin/settings/backupdatabase','icon' => 'fa fa-database'],
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

        if($this->request->isMethod('POST')){

            foreach($this->request->all() as $key => $value){
              Settings::where('setting', '=', $key)->update(['value' => $value]);
            }

            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
        }

        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/website',[
                                                        'settings' => \App\Model\Settings::getAll(),
                                                    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminarea($slug){


        if($this->request->isMethod('POST')){

            foreach($this->request->all() as $key => $value){
              Settings::where('setting', '=', $key)->update(['value' => $value]);
            }

            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
        }

        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/adminarea',[
                                                        'settings' => Settings::getAll(),
                                                        'languages' => ['English','Magyar'],
                                                    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatecenter($slug){

        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/updatecenter',[
                                                        'current_version' => \App\Model\Update::getCurrentVersion(),
                                                        'latest_version' => \App\Model\Update::getLatestVersion(),
                                                        'available_list' => \App\Model\Update::getAllAvailable(),
                                                        'upgrade_list' => \App\Model\Update::getUpgrades(),
                                                        'installed_version' => \App\Model\Update::getCore(),

                                                    ]);
    }


    public function server(){
        $this->view->title("Server");
        return $this->view->render('settings/server',[

                                        ]);
    }




}
