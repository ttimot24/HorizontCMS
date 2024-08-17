/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
import * as bootstrap from "bootstrap";
import "bootstrap-fileinput";

import CKEditor from 'ckeditor4-vue';
import TextEditor from './components/TextEditor.vue';
import LockScreen from './components/LockScreen.vue';
import FileManager from './components/FileManager.vue';
import { createI18n, useI18n } from 'vue-i18n-composable';

window.vue.use(CKEditor);

/*const i18n = createI18n({
    locale:  window.navigator.language.split('-')[0],
    fallbackLocale: 'en', // set fallback locale
    messages: {
    }
});*/

const hcms = new window.vue({
    name: 'HorizontCMS',
    el: '#hcms',
   // i18n,
    data: {

    },
  /*  setup() {
        return {
        ...useI18n()
        }
    }, */
    provide() {
        return {
          bootstrap: bootstrap
        }
    },
    components: {
        TextEditor,
        LockScreen,
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

window.bootstrap = bootstrap;