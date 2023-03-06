<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;


class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $admin_logo = $request->settings['admin_logo'];

        $this->view->title(trans('dashboard.title'));
        return $this->view->render("dashboard/index", [

            'domain' => $request->getHost(),
            'server_ip' => isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : "unknown",
            'client_ip' => $request->ip(),
            'blogposts'  => \App\Model\Blogpost::count(),
            'users' => \App\Model\User::count(),
            'visits' => \App\Model\Visits::count(),
            'admin_logo' => ($admin_logo != "" && file_exists("storage/images/logos/" . $admin_logo)) ? "storage/images/logos/" . $admin_logo : \Config::get('horizontcms.admin_logo'),
            'disk_space' => @(disk_free_space("/") / disk_total_space("/")) * 100,
            'upgrade' => $request->settings['auto_upgrade_check'] == 1 && \Auth::user()->hasPermission('settings') ? \App\Model\SystemUpgrade::checkUpgrade() : NULL,

        ]);
    }

    public function show($method){
        return $this->{$method}();
    }


    public function unauthorized()
    {
        $this->view->title('Access denied');
        return $this->view->render('errors/unauthorized');
    }
}
