import Vue from 'vue';
import CKEditor from 'ckeditor4-vue';

import TextEditor from './components/TextEditor.vue';

Vue.use(CKEditor);

var texteditor = new Vue({
    name: 'TextEditor',
    el: '#texteditor',
    data: {

    },
    components: {
        TextEditor
    },
    created: function(){
        console.log("HorizontCMS: TextEditor started");
    }

});

window.texteditor = texteditor;