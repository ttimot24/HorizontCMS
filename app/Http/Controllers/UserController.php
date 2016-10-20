<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\User;

class UserController extends Controller{
 

    protected $itemPerPage = 100;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug){


        $this->view->title(trans('user.users'));
        return $this->view->render('users/index',[
                                                        'number_of_users' => User::count(),
                                                        'all_users' => User::paginate($this->itemPerPage),
                                                        'active_users' => User::where('active',1)->count(),
                                                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        $this->view->title(trans('user.create_user'));
        return $this->view->render('users/create',['roles' => \App\Model\UserRole::all()]);
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

        $this->view->title(trans('user.view_user'));
        return $this->view->render('users/view',['user' => User::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

        $this->view->title(trans('user.edit_user'));
        return $this->view->render('users/edit',[
                                                'user' => User::find($id),
                                                'user_roles' => \App\Model\UserRole::all(),
                                                ]);
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
        
        User::find($id)->delete();

        return $this->redirectToSelf();

    }


}
