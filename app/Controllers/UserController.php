<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\User;

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

         if($this->request->isMethod('POST')){

            $user = new User();
            $user->name = $this->request->input('name');
            $user->username = $this->request->input('username');
            $user->slug = str_slug($this->request->input('username'), "-");
            $user->password = $this->request->input('password');
            $user->email = $this->request->input('email');
            $user->role_id = $this->request->input('role_id');
            $user->visits = 0;
            $user->active = 1;


            if ($this->request->hasFile('up_file')){
                 
                 $user->image = str_replace('images/users/','',$this->request->up_file->store('images/users'));

            }


            if($user->save()){

            	return $this->redirect(admin_link("user-edit",$user->id))->withMessage(['success' => trans('message.successfully_created_user')]);
            }else{
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }


            
        }



        $this->view->title(trans('user.create_user'));
        return $this->view->render('users/create',[
                                                    'current_user' => \Auth::user(),
                                                    'roles' => \App\Model\UserRole::all()
                                                ]);
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
        return $this->view->render('users/view',[
                                                    'user' => User::find($id),
                                                    'previous_user' => User::where('id', '<', $id)->max('id'),
                                                    'next_user' =>  User::where('id', '>', $id)->min('id'),
                                                ]);
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
                                                'current_user' => \Auth::user(),
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
    public function update($id){
        if($this->request->isMethod('POST')){

            $user = User::find($id);
            $user->name = $this->request->input('name');
            $user->username = $this->request->input('username');
            $user->slug = str_slug($this->request->input('username'), "-");
            $user->email = $this->request->input('email');

            if($this->request->has('password')){
                $user->password = $this->request->input('password');
            }

            $user->role_id = $this->request->input('role_id');
           // $user->active = 1;


            if ($this->request->hasFile('up_file')){
                 
                 $user->image = str_replace('images/users/','',$this->request->up_file->store('images/users'));

            }

            if($user->save()){
                return $this->redirect(admin_link("user-edit",$user->id))->withMessage(['success' => trans('message.successfully_updated_user')]);
            }else{
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }


            
        }
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
        
        if(User::find($id)->delete()){
            return $this->redirect(admin_link("user-index"))->withMessage(['success' => trans('message.successfully_deleted_user')]);
        }


        return $this->redirect(admin_link("user-index"))->withMessage(['danger' => trans('message.something_went_wrong')]);

    }


}
