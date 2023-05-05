import * as jquery from "jquery";
import Vue from 'vue';
import VueResource from "vue-resource";

Vue.use(VueResource);

//window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

const csrfToken: HTMLElement = document.head.querySelector('meta[name="csrf-token"]') as HTMLElement;

Vue.mixin({
    data: function() {
      return {
        get csrfToken() {
          return csrfToken?.getAttribute('content');
        }
      }
    }
});

window.$ = jquery;
window.vue = Vue;
