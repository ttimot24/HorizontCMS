import * as jquery from "jquery";
import Vue from 'vue';
import VueResource from "vue-resource";
//import VueI18n from 'vue-i18n';
import axios, { Axios } from  'axios-observable';

Vue.use(VueResource);
//Vue.use(VueI18n);

Vue.config.devtools = true;

const csrfToken: HTMLElement = document.head.querySelector('meta[name="csrf-token"]') as HTMLElement;
const apiToken: HTMLElement = document.head.querySelector('meta[name="api-token"]') as HTMLElement;

axios.defaults.headers.common['Content-Type'] = "application/json";
axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
axios.defaults.headers.common['Authorization'] = 'Bearer ' + apiToken.getAttribute('content');

Vue.prototype.http = axios;

Vue.mixin({
    data: function() {
      return {
        get csrfToken(): string | null {
          return csrfToken?.getAttribute('content');
        }
      }
    }
});

window.$ = jquery;
window.vue = Vue;
