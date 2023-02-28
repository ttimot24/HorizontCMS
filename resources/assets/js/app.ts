/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

import * as $ from 'jquery';
import "bootstrap";
import "bootstrap-fileinput";

/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueResource from 'vue-resource';
import axios from 'axios';
import CKEditor from 'ckeditor4-vue';

import LockScreen from './components/LockScreen.vue';
import FileManager from './components/FileManager.vue';
import TextEditor from './components/TextEditor.vue';

Vue.config.devtools = true;
Vue.use(VueResource);

Vue.use(CKEditor);

//Vue.prototype.$http = axios;

/*Vue.prototype.$http.interceptors.push((request: Request, next) => {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

    next();
}); */

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

window.hcms = new Vue({
    el: '#hcms',
    data: {

    },
    components: {
        LockScreen,
        TextEditor,
        FileManager
    },
    created: function(){
        console.log("HorizontCMS: VueJS started");
    }

});