<?php

namespace App\Controllers;

use App\Controllers\Trait\UploadsImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Model\User;

class UserController extends Controller
{

    use UploadsImage;

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
        return view('users.index', [
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
        return view('users.form', [
            'current_user' => request()->user(),
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

        $request->validate(User::$rules);
        
        $user = new User($request->all());
        $user->slug = str_slug($request->input('username'), "-");
        $user->visits = 0;
        $user->active = 1;

        $this->uploadImage($user);

        if ($user->save()) {

            return redirect(route("user.edit", ['user' => $user]))->withMessage(['success' => trans('message.successfully_created_user')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
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
        return view('users.view', [
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
        return view('users.form', [
            'current_user' => request()->user(),
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
        
        $this->uploadImage($user);

        if ($user->save()) {
            return redirect(route("user.edit", ['user' => $user]))->withMessage(['success' => trans('message.successfully_updated_user')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
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
            return redirect()->back()->withMessage(['success' => trans('User successfully activated!')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
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
            return redirect(route("user.index"))->withMessage(['success' => trans('message.successfully_deleted_user')]);
        }


        return redirect(route("user.index"))->withMessage(['danger' => trans('message.something_went_wrong')]);
    }
}
