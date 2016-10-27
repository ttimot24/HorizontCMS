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
    public function index($slug){

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $this->view->title(trans('page.view_page'));
        return $this->view->render('settings/view',[ ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){

    }


}
