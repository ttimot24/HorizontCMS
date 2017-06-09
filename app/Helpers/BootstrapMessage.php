<?php


class BootstrapMessage{


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






}