/**
 * Load the actual Bootstap version
 */

require('bootstrap');

/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.config.devtools = true

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

CKEditor = require('ckeditor4-vue');
Vue.use(CKEditor);

var app = new Vue({
    el: '#hcms',
    data:{
    	

    },
    created: function(){
        console.log("HorizontCMS: VueJS started");
        
   
        window.addEventListener('keypress', (event) => {
            
            if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;
            
            $("#submit-btn").click();
            event.preventDefault();
            return false;
            
        });



    }

});
