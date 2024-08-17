<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Model\User;

class UserEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
    }


    public function countLogin(Login $event){
        if(!$this->request->expectsJson()){
            $event->user->increment('visits');
        }
    }


    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //
    }
}
