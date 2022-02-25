<?php


class BootstrapMessage{

    private function alertTemplate($args){
       return "<div class='alert alert-dismissible alert-".$args['class']."'>
              <i class='bi ".$args['icon']."'></i>
              <strong>" .$args['title'] ."</strong>&nbsp" .$args['message']."
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }


    public function success($message){

      return $this->alertTemplate(['class'=> 'success','icon' => '', 'title'=> 'Success', 'message' => $message]);
    }


    public function error($message){
     
       return $this->alertTemplate(['class'=> 'error','icon' => '', 'title'=> 'Error', 'message' => $message]);
        
    }



    public function warning($message){
       
      return $this->alertTemplate(['class'=> 'warning','icon' => '', 'title'=> 'Warning', 'message' => $message]);

    }




    public function note($message){

      return $this->alertTemplate(['class'=> 'info','icon' => '', 'title'=> 'Note', 'message' => $message]);

    }


}