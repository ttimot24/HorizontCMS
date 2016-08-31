<?php


class Message{

  private $text = array(); 


    public function __construct(){

      if (!isset($_SESSION['messages'])) {
          $_SESSION['messages'] = array();
      }

    }

    public function setMessage($type,$message){
        array_push($_SESSION['messages'],$this->{$type}($message));
    }

    public function hasMessage(){
        if(isset($_SESSION['messages'])){
          return True;
        }
        else{
          return False;
        }
    }

    public function getMessage(){

      $messages = $_SESSION['messages'];

      unset($_SESSION['messages']);

        return $messages;
    }




    public function success($message){

    	$title = "Success!";

      return "<div class='alert alert-success <!--fade in-->'>
             <a href='#' class='close' data-dismiss='alert'>&times;</a>
             <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
             <strong>" .$title ."</strong>&nbsp" .$message ."
             </div>";
      }


    public function error($message){

    	$title = "Error!";

    return "<div class='alert alert-danger alert-error <!--fade in-->'>
           <a href='#' class='close' data-dismiss='alert'>&times;</a>
           <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
           <strong>".$title ."</strong> ".$message."
           </div>";

        
    }



    public function warning($message){

    	$title = "Warning!";

    	return "<div class='alert alert-warning <!--fade in-->'>
               <a href='#' class='close' data-dismiss='alert'>&times;</a>
               <span class='glyphicon glyphicon-warning-sign' aria-hidden='true'></span>
               <strong>" .$title ."</strong>&nbsp" .$message ."
               </div>";
    }




    public function note($message){

    	$title = "Note!";

      return "<div class='alert alert-info <!--fade in-->'>
              <a href='#' class='close' data-dismiss='alert'>&times;</a>
              <span class='glyphicon glyphicon-info-sign' aria-hidden='true'></span>
              <strong>" .$title ."</strong>&nbsp" .$message ."
              </div>";

    }


    public function delete_confirmation($modal_id,$header=NULL,$message=NULL,$footer=NULL){

      echo "<div class='modal ".$modal_id."' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header modal-header-danger'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h4 class='modal-title'>".$header."</h4>
                  </div>
                  <div class='modal-body'>
                    <p>".$message."</p>
                  </div>
                  <div class='modal-footer'>".$footer."</div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
                ";


    }



}

?>