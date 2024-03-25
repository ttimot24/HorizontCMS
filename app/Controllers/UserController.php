<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;
use App\Model\User;

class UserController extends Controller
{


    protected $itemPerPage = 100;
    protected $imagePath = 'images/users';

    /**
     * Creates image directories if they not exists.
     *
     * @return \Illuminate\Http\Response
     */
    public function before()
    {
        \File::ensureDirectoryExists($this->imagePath . '/thumbs');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $this->view->title(trans('user.users'));
        return $this->view->render('users/index', [
            'number_of_users' => User::count(),
            'all_users' => User::paginate($this->itemPerPage),
            'active_users' => User::where('active', 1)->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->view->title(trans('user.create_user'));
        return $this->view->render('users/form', [
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
    public function store(Request $request)
    {

        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $user = new User($request->all());
        $user->slug = str_slug($request->input('username'), "-");
        $user->visits = 0;
        $user->active = 1;


        if ($request->hasFile('up_file')) {

            $img = $request->up_file->store($this->imagePath);

            $user->attachImage($img);

            if (extension_loaded('gd')) {
                \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save($user->getThumbnailDirectory(). DIRECTORY_SEPARATOR . $user->image);
            }
        }


        if ($user->save()) {

            return $this->redirect(route("user.edit", ['user' => $user]))->withMessage(['success' => trans('message.successfully_created_user')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        $this->view->title(trans('user.view_user'));
        return $this->view->render('users/view', [
            'user' => $user,
            'previous_user' => User::where('id', '<', $user->id)->max('id'),
            'next_user' =>  User::where('id', '>', $user->id)->min('id'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $this->view->title(trans('user.edit_user'));
        return $this->view->render('users/form', [
            'current_user' => $this->request->user(),
            'user' => $user,
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
    public function update(Request $request, User $user)
    {

        $user->fill($request->all());
        $user->slug = str_slug($request->input('username'), "-");

        if ($request->has('password')) {
            $user->password = $request->input('password');
        } 

        if ($request->hasFile('up_file')) {

            $img = $request->up_file->store($this->imagePath);

            $user->attachImage($img);

            if (extension_loaded('gd')) {
                \Intervention\Image\ImageManagerStatic::make(storage_path($img))->fit(300, 200)->save($user->getThumbnailDirectory(). DIRECTORY_SEPARATOR . $user->image);
            }
        }

        if ($user->save()) {
            return $this->redirect(route("user.edit", ['user' => $user]))->withMessage(['success' => trans('message.successfully_updated_user')]);
        } else {
            return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    /**
     * Activates a user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $user = \App\Model\User::find($id);

        $user->active = 1;

        if ($user->save()) {
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
    public function destroy(User $user)
    {

        if ($user->delete()) {
            return $this->redirect(route("user.index"))->withMessage(['success' => trans('message.successfully_deleted_user')]);
        }


        return $this->redirect(route("user.index"))->withMessage(['danger' => trans('message.something_went_wrong')]);
    }
}
