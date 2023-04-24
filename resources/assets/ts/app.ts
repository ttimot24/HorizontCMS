/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
import * as jquery from "jquery";
import * as bootstrap from "bootstrap";
import "bootstrap-fileinput";

import VueResource from 'vue-resource';

import CKEditor from 'ckeditor4-vue';
import TextEditor from './components/TextEditor.vue';
import LockScreen from './components/LockScreen.vue';
import FileManager from './components/FileManager.vue';

window.vue.config.devtools = true;
window.vue.use(VueResource);
window.vue.use(CKEditor);

window.vue.component('text-editor', TextEditor);
window.vue.component('lock-screen', LockScreen);
window.vue.component('file-manager', FileManager);

const hcms = new window.vue({
    name: 'HorizontCMS',
    el: '#hcms',
    data: {

    },
    provide() {
        return {
          bootstrap: bootstrap
        }
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

window.$ = jquery;
window.bootstrap = bootstrap;