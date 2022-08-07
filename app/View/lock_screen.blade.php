

<div class='modal fade' id='lock_screen' role='dialog' v-on:keydown.enter="lockUpScreen" aria-labelledby='myModalLabel' aria-hidden='true'>
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
						  		<input type='password' class='form-control w-100' id='lock_pwd' v-model="pwd" required/>
							</div>
						</div>


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
	name: 'lock-screen',
	data:{
		pwd: ''
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

			axios.post('/api/v1/lock-up',
				{
		        	_token: "<?= csrf_token() ?>",
		            id: <?= \Auth::user()->id ?>,
		            password: this.pwd
		        }
			).then(function(response){

				if(response.data){

					$('#lock_screen').modal('hide');
					localStorage.locksession = 'false';

				}

				this.pwd='';

			}).catch(function(error){
				this.pwd='';
				console.log(error);
			});

		}
	}
});



</script>
