<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;
use Session;
use Config;
use Schema;


class InstallController extends Controller{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){


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


        foreach (Config::get('database.connections') as $database) {
            $db_drivers[$database['name']] = $database['driver'];
        }

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


           $this->request->flash();

            try{

                new \PDO($this->request->input('db_driver').':host='.$this->request->input('server').';', 
                    $this->request->input('username'), 
                    $this->request->input('password')
                );

                Session::put('step2',$this->request->all());

                return $this->redirect('admin/install/step3')->withMessage(['success' => trans('Connection with database established!')]);
            }catch(\PDOException $except){
               return $this->redirectToSelf()->withMessage(['danger' => trans('Can not establish the connection: '.$except->getMessage())]);
            }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function step3(){

        $this->request->flash();

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


        Config::set('database.default',Session::get('step2.db_driver'));
        Config::set('database.connections.'.Session::get('step2.db_driver').'.host', Session::get('step2.server'));
        Config::set('database.connections.'.Session::get('step2.db_driver').'.username', Session::get('step2.username'));
        Config::set('database.connections.'.Session::get('step2.db_driver').'.password', Session::get('step2.password'));
        Config::set('database.connections.'.Session::get('step2.db_driver').'.database', Session::get('step2.database'));
        Config::set('database.connections.'.Session::get('step2.db_driver').'.prefix',Session::get('step2.prefix'));

        \Artisan::call("migrate", ["--force"=> true ]);
        \Artisan::call("db:seed", ["--force"=> true ]);

        $administrator = new \App\User();
        $administrator->name = 'Administrator';
        $administrator->username = $this->request->input('ad_username');
        $administrator->slug = str_slug($this->request->input('ad_username'));
        $administrator->password = \Hash::make($this->request->input('ad_password'));
        $administrator->email = $this->request->input('ad_email');
        $administrator->role_id = 6;

        if($administrator->save()){

            $dotenv = new \App\Libs\DotEnvGenerator();
            $dotenv->addEnvVar('DB_HOST', Session::get('step2.server'));
            $dotenv->addEnvVar('DB_CONNECTION',  Session::get('step2.db_driver'));
            $dotenv->addEnvVar('DB_USERNAME',  Session::get('step2.username'));
            $dotenv->addEnvVar('DB_PASSWORD',  Session::get('step2.password'));
            $dotenv->addEnvVar('DB_DATABASE',  Session::get('step2.database'));
            $dotenv->addEnvVar('DB_TABLE_PREFIX',  Session::get('step2.prefix'));
            $dotenv->generate();

            $systemupgrade = new \App\Model\SystemUpgrade();
            $systemupgrade->version = \Config::get('horizontcms.version');
            $systemupgrade->nickname = "Core";
            $systemupgrade->importance = "most important";
            $systemupgrade->description = "welcome!";

            $systemupgrade->save();

        }else{
            return $this->redirect('admin/install/step4')->withMessage(['danger' => 'Something went wrong!']);
        }


        return $this->redirect('admin/install/step4')->withMessage(['success' => 'Succesfully installed!']);
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
