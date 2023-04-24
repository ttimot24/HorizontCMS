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

import TextEditor from './components/TextEditor.vue';
import LockScreen from './components/LockScreen.vue';
import FileManager from './components/FileManager.vue';

Vue.config.devtools = true;
Vue.use(VueResource);

Vue.component('text-editor',  TextEditor);
Vue.component('lock-screen',  LockScreen);
Vue.component('file-manager',  FileManager);

window.vue = Vue;

window.$ = jquery;
window.bootstrap = bootstrap;