import * as $ from 'jquery';
import axios from 'axios';
import "bootstrap";
import { Modal } from 'bootstrap';

class LockScreen {

    private modal: any;

    constructor(){
        this.modal = new Modal(document.getElementById('lock_screen') as HTMLElement);
    }

    lockUpScreenMounted(){

        if(typeof(Storage) !== "undefined") {
        
            if(localStorage.locksession != null){
                if(localStorage.locksession=='true'){
                    this.modal.show();
                }
                else if(localStorage.locksession=='false'){
                    this.modal.hide();
                }
            }
        }

    };

    lock(){
        this.modal.show();
        localStorage.locksession = 'true';
    };

    unlock(userId: string){

        
        var pwd: string | null = ($("#lock_pwd").val()) as string;

            axios.post('/api/v1/lock-up',
                {
                    id: userId,
                    password: pwd
                }
            ).then((response) => {

                if(response.data){

                    this.modal.hide();
                    localStorage.locksession = 'false';

                }

                pwd = null;

            }).catch((error) => {
                pwd = null;
                console.log(error);
            });

        };

}



window.lockscreen = new LockScreen();
window.lockscreen.lockUpScreenMounted();
