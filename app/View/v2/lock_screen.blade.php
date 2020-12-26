

<div class='modal fade' id='lock_screen' role='dialog' v-on:keydown.enter="lockUpScreen" aria-labelledby='myModalLabel' aria-hidden='true'>
		  <div class='modal-dialog modal-md'>
		    <div class='modal-content'>
		      <div class='modal-header '>
		      <h2 class='text-primary color-primary'><i class="fa fa-lock"></i> Screen is locked</h2>
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
				        <button type='button' id='unlock_button' class='btn btn-primary' v-on:click="lockUpScreen">Unlock</button>
				      </div>
		    </div>
	</div>
</div>


<script>

var lockScreen = new Vue({
	el: '#lock_screen',
	data:{

	},
	created: function(){

		if(typeof(Storage) !== "undefined") {
		
			if(localStorage.locksession!=null){
	
						if(localStorage.locksession=='true'){
			                $('#lock_screen').modal('show');
			            }
			            else if(localStorage.locksession=='false'){
			                $('#lock_screen').modal('hide');
			            }
			}
		}

	},
	methods:{
		lockUpScreen: function(){
		    $.ajax({
		        //url:'admin/screen-lock/lock-up',
		        url:'api/lock-up',
		        type: 'POST',
		        data: {
		        	_token: "<?= csrf_token() ?>",
		            id: <?= \Auth::user()->id ?>,
		            password: $('#lock_pwd').val()
		        },
		        success: function( data ){

		        	if(data===true){

		        		$('#lock_screen').modal('hide');
		        		localStorage.locksession = 'false';
		        		console.log(localStorage);

		        	}

		        	$('#lock_pwd').val('');
		        },
		        error: function ( xhr, status, error ) {
		  			alert(xhr.responseText);
		        }
		    });
		}
	}
});



</script>
