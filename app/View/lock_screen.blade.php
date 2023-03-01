<script src="{{asset('resources/js/lock-screen.js')}}"></script>

<div class='modal fade' id='lock_screen' role='dialog' keydown.enter="lockscreen.lockUpScreen('{{ \Auth::user()->id }}')" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby='myModalLabel' aria-hidden='true'>
		  <div class='modal-dialog modal-lg'>
		    <div class='modal-content'>
		      <div class='modal-header '>
		      <h2 class='text-primary color-primary'><i class="fa fa-lock"></i> Screen is locked</h2>
		      </div>
		      <div class='modal-body text-center'>

		    	 <img src='{{\Auth::user()->getThumb()}}' class='img-thumbnail' style='max-height:15rem; object-fit:cover;'>



		    			<div class='form-group'>
						  <label for='usr'>{{\Auth::user()->username}}</label>
						</div>

		    			<div class='form-group'>
						  <label for='pwd'>Password:</label>
						  	<div class='input-group'>
						  		<input type='password' class='form-control w-100' id='lock_pwd' required/>
							</div>
						</div>


		    </div>
		    	      <div class='modal-footer'>
				        <button type='button' id='unlock_button' class='btn btn-primary' onclick="lockscreen.unlock('{{ \Auth::user()->id }}')">Unlock</button>
				      </div>
		    </div>
	</div>
</div>