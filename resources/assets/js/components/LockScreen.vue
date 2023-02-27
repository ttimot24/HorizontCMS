<template>

<div class='modal fade' id='lock_screen' ref="lock-screen" role='dialog' v-on:keydown.enter="lockUpScreen" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby='myModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		      <div class='modal-header '>
		      <h2 class='text-primary color-primary'><i class="fa fa-lock"></i> Screen is locked</h2>
		      </div>
		      <div class='modal-body text-center'>

		    	 <img :src='image' class='img-thumbnail' style='max-height:15rem; object-fit:cover;'>

		    			<div class='form-group'>
						  <label for='usr'>{{username}}</label>
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
</template>



<script lang="ts" async="async">
	import * as $ from 'jquery';
	import { defineComponent } from '@vue/composition-api';
	import axios from 'axios';
	import { Modal } from 'bootstrap';

	export default defineComponent({
		name: 'lock-screen',
		props: {
			csrf: String,
			userId: Number,
			username: String,
			image: String,
		},
		data: function() {
			return {
				pwd: null,
				modal: null
			}
		},
		created: function() {

			this.modal = new Modal(this.$refs['lock-screen']);

			if(typeof(Storage) !== "undefined") {
			
				if(localStorage.locksession != null){
					if(localStorage.locksession=='true'){
						(this.modal as any).modal({show: true});
					}
					else if(localStorage.locksession=='false'){
						(this.modal as any).modal({show: false});
					}
				}
			}

		},
		methods:{
			lockUpScreen: function(){

				axios.post('/api/v1/lock-up',
					{
						password: this.pwd
					}
				).then((response) => {

					if(response.data){

						(this.modal as any).modal('hide');
						localStorage.locksession = 'false';

					}

					this.pwd=null;

				}).catch((error) => {
					this.pwd=null;
					console.log(error);
				});

			}
		}
	});
</script>