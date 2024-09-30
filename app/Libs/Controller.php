<?php

namespace App\Libs;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Libs\ViewResolver;
use Illuminate\Http\Request;

/**
 * @deprecated deprecated since version 1.0.0
 */
abstract class Controller extends BaseController {
	
    /**
     * @deprecated deprecated since version 1.0.0
     */
    protected $request;

    /**
     * @deprecated deprecated since version 1.0.0
     */
    protected $view;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @deprecated deprecated since version 1.0.0
     */
    public function __construct(Request $request,ViewResolver $viewResolver){
    	$this->request = $request;	

        $this->view = $viewResolver;
    }

    /**
     * @deprecated deprecated since version 1.0.0
     */
    public function redirect($location){
    	return redirect($location);
    }

    /**
     * @deprecated deprecated since version 1.0.0
     */
    public function redirectToSelf(){
        return redirect()->back();
    }

}
