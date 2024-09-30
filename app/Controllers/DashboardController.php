<?php

namespace App\Controllers;

use Illuminate\Routing\Controller;


class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $updater = new \Codedge\Updater\UpdaterManager(app());

        $admin_logo = request()->settings['admin_logo'];


        return view("dashboard.index", [
            'domain' => request()->getHost(),
            'server_ip' => isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : "unknown",
            'client_ip' => request()->ip(),
            'blogposts'  => \App\Model\Blogpost::count(),
            'users' => \App\Model\User::count(),
            'visits' => \App\Model\Visits::count(),
            'admin_logo' => ($admin_logo != "" && file_exists("storage/images/logos/" . $admin_logo)) ? "storage/images/logos/" . $admin_logo : \Config::get('horizontcms.admin_logo'),
            'disk_space' => @((disk_free_space("/") ?: 1) / (disk_total_space("/") ?: 1)) * 100,
            'upgrade' => request()->settings['auto_upgrade_check'] == 1 && \Auth::user()->hasPermission('upgrade')? $updater->source() : null,
        ]);
    }

    public function show($method){
        return $this->{$method}();
    }


    public function unauthorized()
    {
        return view('errors.unauthorized');
    }

    public function notfound()
    {
        return view('errors.404');
    }
}
