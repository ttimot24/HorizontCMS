<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;


class InstallController extends Controller{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($step = 'index'){


        $this->view->title("Install");
        return $this->view->render("install/index",['enable_continue' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function step1(){

        $languages = ['English','Magyar','Deutsch'];

        $this->view->title("Install");
        return $this->view->render("install/step1",['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function step2(){
        
        $db_drivers = ['MySQL' => 'mysql','PostgreSQL' => 'pgsql','SQLite' => 'sqlite'];

        $this->view->title("Install");
        return $this->view->render("install/step2",['db_drivers' => $db_drivers]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkConnection(){

            if(TRUE){
                return $this->redirect('admin/install/step3')->withMessage(['success' => trans('Connection with database established!')]);
            }else{
               return $this->redirectToSelf()->withMessage(['danger' => trans('Can not establish the connection!')]);
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function step3(){
        $this->view->title("Install");
        return $this->view->render("install/step3");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function migrate(){
        
          
        return $this->redirect('admin/install/step4')->withMessage(['success' => trans('Succesfully migrated!')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function step4(){
        $this->view->title("Install");
        return $this->view->render("install/step4");
    }



}
