<div class='w-50'>
<?php

  if(session()->has('message')){
    foreach(session()->get('message') as $key => $value){

    echo "<br>
    <div class='alert alert-".$key." alert-dismissible' role='alert'>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";

      if($key == 'success')
        echo "<span class='fa fa-ok' aria-hidden='true'></span> ";
      else if($key == 'danger')
        echo "<span class='fa fa-exclamation-sign' aria-hidden='true'></span>";
      else if($key == 'warning')
        echo "<span class='fa fa-warning-sign' aria-hidden='true'></span>";
      else if($key == 'info'){
        echo " <span class='fa fa-info-sign' aria-hidden='true'></span>";
      }

      
echo "<strong>". ucfirst($key) ."!</strong> ".$value."
    </div>";
    }
  }
?>

</div>