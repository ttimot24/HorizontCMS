<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Settings;

class DashboardController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $this->view->title(trans('dashboard.title'));
        return $this->view->render("dashboard/index",[

                                                    'domain' => $_SERVER['SERVER_NAME'],
                                                    'server_ip' => $_SERVER['SERVER_ADDR'],
                                                    'client_ip' => $this->request->ip,
                                                    'blogposts'  => \App\Model\Blogpost::count(),
                                                    'users' => \App\Model\User::count(),
                                                    'visits' => \App\Model\Visits::count(),
                                                    'admin_logo' => \Config::get('horizontcms.admin_logo'),
                                                    'disk_space' => @(disk_free_space("/")/disk_total_space("/"))*100,
                                                    'latest_version' => Settings::get('auto_upgrade_check')==0? NULL : \App\Model\SystemUpgrade::getLatestVersion(),
                                                    'current_version' => Settings::get('auto_upgrade_check')==0? NULL : \App\Model\SystemUpgrade::getCurrentVersion()->version,

            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
