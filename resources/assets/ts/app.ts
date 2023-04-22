/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
import * as jquery from "jquery";
import * as bootstrap from "bootstrap";
import "bootstrap-fileinput";

import Vue from 'vue';
import VueResource from 'vue-resource';

import CKEditor from 'ckeditor4-vue';
import TextEditor from './components/TextEditor.vue';
import LockScreen from './components/LockScreen.vue';
import FileManager from './components/FileManager.vue';

Vue.config.devtools = true;
Vue.use(VueResource);
Vue.use(CKEditor);

const hcms = new Vue({
    name: 'HorizontCMS',
    el: '#hcms',
    data: {

    },
    provide() {
        return {
          bootstrap: bootstrap
        }
    },
    components: {
        LockScreen,
        TextEditor,
        FileManager
    },
    created: function(){
        console.log("HorizontCMS started");
    },
    methods: {
        lock: function(){
            this.$refs.lockscreen.lock();
        },
    }

});

export default hcms;

window.hcms = hcms;
window.vue = Vue;

window.$ = jquery;
window.bootstrap = bootstrap;