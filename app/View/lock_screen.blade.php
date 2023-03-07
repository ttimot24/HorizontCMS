<div class='modal fade' id='lock_screen' role='dialog' v-on:keydown.enter="unlock('{{ \Auth::user()->id }}');" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='modal-header '>
				<h2 class='text-primary color-primary'><i class="fa fa-lock"></i> Screen is locked</h2>
			</div>
			<div class='modal-body text-center'>

				<div>
					<img src="{{\Auth::user()->getThumb()}}" class='img-thumbnail' style='max-height:15rem; object-fit:cover;' />
					<br>
					<b class="fs-5 m-3">{{\Auth::user()->username}}</b>
				</div>
					

				<div class='form-group mt-5'>
					<label for='pwd'>{{trans('login.password')}}:</label>
						<input type='password' class='form-control w-100' id='lock_pwd' required/>
							<span class="invalid-feedback" role="alert">
								<strong>Wrong password</strong>
							</span>
				</div>


			</div>
			<div class='modal-footer'>
				<button type='button' id='unlock_button' class='btn btn-primary' onclick="lockscreen.unlock('{{ \Auth::user()->id }}');">{{trans('actions.unlock')}}</button>
			</div>
		</div>
		</div>
	</div>

<script src="{{asset('resources/js/lock-screen.js')}}"></script>
