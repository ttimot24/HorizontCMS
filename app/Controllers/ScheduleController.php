<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;
use App\Model\ScheduledTask;

class ScheduleController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

    }

    public function create(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request){
    
        $task = new ScheduledTask($request->all());
        $task->active = 1;

        if($task->save()){
            return $this->redirectToSelf()->withMessage(['succes' => trans('Succesfully scheduled a task!')]);
        }else{
          	return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    public function edit(){

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id){

    }

    /**
     * Remove the specified resource from database.
     *
     * @param  \App\Model\ScheduledTask  $scheduledtask
     * @return \Illuminate\Http\Response
    */
    public function destroy(ScheduledTask $schedule){
        

        if($schedule->delete()){
			return $this->redirectToSelf()->withMessage(['success' => trans('Successfully deleted the task!')]);
        }

        return $this->redirect(route("settings.show",['setting' => 'schedules']))->withMessage(['danger' => trans('message.something_went_wrong')]);

    }

}
