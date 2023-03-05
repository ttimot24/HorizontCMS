import * as $ from 'jquery';
import axios from 'axios';
import { Modal } from 'bootstrap';
import Vue from 'vue';

var lockscreen = new Vue({
    name: 'LockScreen',
    el: '#lock_screen',
    data: {

    },
    mounted: function() {

        var vm = this;

        vm.modal = new Modal(document.getElementById('lock_screen') as HTMLElement);

        if (typeof (Storage) !== undefined) {

            if (localStorage.locksession != null) {
                if (localStorage.locksession == 'true') {
                    this.modal.show();
                }
                else if (localStorage.locksession == 'false') {
                    this.modal.hide();
                }
            }
        }

    },
    methods: {
        lock: function(): void {
            var vm = this;
            vm.modal.show();
            localStorage.locksession = 'true';
            vm.invalid_pw = false;
        },
        unlock: function(userId: string): void {
            var vm = this;

            var password_field: any = $("#lock_pwd");

            axios.post('/api/v1/lock-up',
                {
                    id: userId,
                    password: (password_field.val()) as string,
                }
            ).then((response) => {

                if (response.data) {

                    vm.modal.hide();
                    localStorage.locksession = 'false';

                } else {
                    password_field.addClass('is-invalid');
                }

                password_field = null;

            }).catch((error) => {
                password_field = null;
                console.log(error);
            });

        }
    }
});

window.lockscreen = lockscreen;
