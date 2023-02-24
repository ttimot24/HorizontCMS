<?php

namespace App\Controllers;

use App\Libs\Controller;

use App\Model\User;

class UserController extends Controller{
 

    protected $itemPerPage = 100;
    protected $imagePath = 'images/users';

    /**
     * Creates image directories if they not exists.
     *
     * @return \Illuminate\Http\Response
    */
    public function before(){
        if(!file_exists(storage_path($this->imagePath.'/thumbs'))){
            \File::makeDirectory(storage_path($this->imagePath.'/thumbs'), $mode = 0777, true, true);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){


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


        $this->view->js('resources/js/controls.js');

        $this->view->title(trans('user.create_user'));
        return $this->view->render('users/form',[
                                                    'current_user' => $this->request->user(),
                                                    'role_options' => \App\Model\UserRole::all()
                                                ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(){
        
        if($this->request->isMethod('POST')){

            $user = new User($this->request->all());
            $user->slug = str_slug($this->request->input('username'), "-");
            $user->visits = 0;
            $user->active = 1;
            

            if ($this->request->hasFile('up_file')){
                 
                 $img = $this->request->up_file->store($this->imagePath);

                 $user->image = basename($img);

                 if(extension_loaded('gd')){
                    \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save(storage_path($this->imagePath.'/thumbs/'.$user->image));
                 }
            }


            if($user->save()){

            	return $this->redirect(route("user.edit",['user' => $user]))->withMessage(['success' => trans('message.successfully_created_user')]);
            }else{
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }
            
        }

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

        $this->view->js('resources/js/controls.js');

        $this->view->title(trans('user.edit_user'));
        return $this->view->render('users/form',[
                                                'current_user' => $this->request->user(),
                                                'user' => User::find($id),
                                                'role_options' => \App\Model\UserRole::all(),
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
        if($this->request->isMethod('PUT')){

            $user = User::find($id);
            $user->name = $this->request->input('name');
            $user->username = $this->request->input('username');
            $user->slug = str_slug($this->request->input('username'), "-");
            $user->email = $this->request->input('email');
            $user->phone = $this->request->input('phone');

            if($this->request->has('password')){
                $user->password = $this->request->input('password');
            }

            $user->role_id = $this->request->input('role_id');
           // $user->active = 1;



            if ($this->request->hasFile('up_file')){
                 
                 $img = $this->request->up_file->store($this->imagePath);

                 $user->image = basename($img);

                 if(extension_loaded('gd')){
                    \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save(storage_path($this->imagePath.'/thumbs/'.$user->image));
                 }
            }




            if($user->save()){
                return $this->redirect(route("user.edit",['user' => $user]))->withMessage(['success' => trans('message.successfully_updated_user')]);
            }else{
                return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }


            
        }
    }

    /**
     * Activates a user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id){
        $user = \App\Model\User::find($id);

        $user->active = 1;

        if($user->save()){
            return $this->redirectToSelf()->withMessage(['success' => trans('User successfully activated!')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }

    }


    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        
        if(User::find($id)->delete()){
            return $this->redirect(route("user.index"))->withMessage(['success' => trans('message.successfully_deleted_user')]);
        }


        return $this->redirect(route("user.index"))->withMessage(['danger' => trans('message.something_went_wrong')]);

    }


}
