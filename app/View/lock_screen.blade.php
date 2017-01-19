<script>

function lock_up_screen(){

    $.ajax({
        url:'admin/screen-lock/lock-up',
        type: 'POST',
        data: {
        	_token: "<?= csrf_token() ?>",
            id: <?= \Auth::user()->id ?>,
            password: $('#lock_pwd').val()
        },
        success: function( data ){

        	if(data===true){
        		$('#lock_screen').modal('hide');
        	}

        	$('#lock_pwd').val('');
        },
        error: function ( xhr, status, error ) {
  			alert(xhr.responseText);
        }
    });

}

</script>


<div class='modal fade' id='lock_screen' role='dialog' onhide='lock_up();' aria-labelledby='myModalLabel' aria-hidden='true'>
		  <div class='modal-dialog modal-md'>
		    <div class='modal-content'>
		      <div class='modal-header '>
		      <h2 class='text-primary'><i class="fa fa-lock"></i> Screen is locked</h2>
		      </div>
		      <div class='modal-body'>

		    	<center>
		    	 <img src='{{\Auth::user()->getThumb()}}' class='img-thumbnail' width='180' style='max-height:200px;object-fit:cover;'>



		    			<div class='form-group'>
						  <label for='usr'>{{\Auth::user()->username}}</label>
						</div>

		    			<div class='form-group'>
						  <label for='pwd'>Password:</label>
						  	<div class='input-group'>
						  		<input type='password' class='form-control' id='lock_pwd' name='lock_pwd' style='width:300px;' required/>
							</div>
						</div>
	

		    	</center>

		    </div>
		    	      <div class='modal-footer'>
				        <button type='button' id='unlock_button' class='btn btn-primary' onclick='lock_up_screen();'>Unlock</button>
				      </div>
		    </div>
	</div>
</div>