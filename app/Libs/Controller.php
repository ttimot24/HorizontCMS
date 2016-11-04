<?php

namespace App\Libs;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = new View();
    }

    public function redirect($location)
    {
        return redirect($location);
    }

    public function redirectToSelf()
    {
        return redirect()->back();
    }

    public function insideLink($location)
    {
        return redirect(\Config::get('horizontcms.backend_prefix').'/'.$location);
    }
}
