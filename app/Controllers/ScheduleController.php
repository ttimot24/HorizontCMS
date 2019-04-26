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
        
        if($this->request->isMethod('POST')){

            $task = new ScheduledTask();
            $task->name = $this->request->input("name");
            $task->command = $this->request->input("command");
            $task->arguments = $this->request->input("arguments");
            $task->frequency = $this->request->input("frequency");
            $task->ping_before = $this->request->input("ping_before");
            $task->ping_after = $this->request->input("ping_after");
            $task->active = 1;

            if($task->save()){
                return $this->redirectToSelf()->withMessage(['succes' => trans('Succesfully scheduled a task!')]);
            }else{
            	return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }

        }

    }

    public function delete($id){
        

        if(ScheduledTask::find($id)->delete()){
			return $this->redirectToSelf()->withMessage(['success' => trans('Successfully deleted the task!')]);
        }


        return $this->redirect(admin_link("blogpost-index"))->withMessage(['danger' => trans('message.something_went_wrong')]);

    }

}
