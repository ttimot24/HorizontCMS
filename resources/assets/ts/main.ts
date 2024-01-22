import * as jquery from "jquery";
import Vue from 'vue';
import VueResource from "vue-resource";
//import VueI18n from 'vue-i18n';
import axios, { AxiosStatic }  from 'axios';

Vue.use(VueResource);
//Vue.use(VueI18n);

Vue.config.devtools = true;

const csrfToken: HTMLElement = document.head.querySelector('meta[name="csrf-token"]') as HTMLElement;

axios.defaults.headers.common['Content-Type'] = "application/json";
axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');

Vue.mixin({
    data: function() {
      return {
        get axios(): AxiosStatic {
            return axios;
        },
        get csrfToken(): string | null {
          return csrfToken?.getAttribute('content');
        }
      }
    }
});

window.$ = jquery;
window.vue = Vue;
