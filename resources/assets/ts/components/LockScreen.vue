<template>
    <div class='modal fade' id='lock_screen' ref="lock_screen" role='dialog' v-on:keydown.enter="unlock"
        data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby='myModalLabel' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header '>
                    <h2 class='text-primary color-primary'><i class="fa fa-lock"></i> Screen is locked</h2>
                </div>
                <div class='modal-body text-center'>

                    <div>
                        <img v-bind:src="'storage/images/users/' + user.image" class='img-thumbnail'
                            style="max-height:15rem; object-fit:cover;" />
                        <br>
              
                        <b class="fs-5 m-3">{{ user.username }}</b>
                    </div>


                    <div class='form-group mt-5'>
                        <label for='pwd'>Password</label>
                        <input type='password' class='form-control w-100' id='lock_pwd' v-model="password" ref="password_field" required />
                        <span class="invalid-feedback" role="alert">
                            <strong>Wrong password</strong>
                        </span>
                    </div>


                </div>
                <div class='modal-footer'>
                    <button type='button' id='unlock_button' class='btn btn-primary'
                        v-on:click="unlock">Unlock</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">

import { Modal } from 'bootstrap';
import { defineComponent } from '@vue/composition-api';
import { User } from './../entity/User';
import { AxiosResponse, AxiosError } from 'axios';
import { environment } from '../environments/environment';

export default defineComponent({
    name: 'LockScreen',
    props: {
        user: {
            type: Object as () => User
        }
    },
    data: function(){
        return {
            password: ''
        }
    },
    mounted: function () {

        var vm = this;

        vm.modal = new Modal(vm.$refs.lock_screen);

        if (typeof (Storage) !== undefined) {

            if (localStorage.locksession != null) {
                if (localStorage.locksession == 'true') {
                    vm.modal.show();
                }
                else if (localStorage.locksession == 'false') {
                    vm.modal.hide();
                }
            }
        }

    },
    methods: {
        lock: function (): void {
            var vm = this;
            vm.modal = new Modal(document.getElementById('lock_screen') as HTMLElement);
            vm.modal.show();
            localStorage.locksession = 'true';
            vm.invalid_pw = false;
        },
        unlock: function (): void {
            var vm = this;

            console.log(vm);

            var password_field: any = $("#lock_pwd");

            this.axios.post(environment.REST_API_BASE+'/lock-up',
                {
                    id: this.user.id,
                    password: (this.password) as string,
                }
            ).then((response: AxiosResponse) => {

                if (response.data) {

                    vm.modal.hide();
                    localStorage.locksession = 'false';

                } else {
                    password_field.addClass('is-invalid');
                }

                password_field = null;

            }).catch((error: AxiosError) => {
                password_field = null;
                console.log(error);
            });

        }
    }
});

</script>