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

Vue.config.devtools = true;
Vue.use(VueResource);

window.vue = Vue;

window.$ = jquery;
window.bootstrap = bootstrap;