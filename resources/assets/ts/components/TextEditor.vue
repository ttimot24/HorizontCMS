<template>
    <div id="text-editor">
        <textarea style="display: none;" v-model="content" :name="name" ></textarea>
        <ckeditor @input="output" v-model="content" :tag-name="'textarea'" :name="name" :config="editorConfig" :editor-url="editorUrl"></ckeditor>
    </div>
</template>

<script lang="ts">

	import { defineComponent } from '@vue/composition-api';

	export default defineComponent({
        name: 'text-editor',
        props: {
            name: {
                type: String,
                default: '',
                required: true
            },
            data: String,
            language: String,
            filebrowserbrowseurl: String,
            filebrowseruploadurl: String,
        },
        data: function() {
            return {
                content: this.data,
                editorUrl: 'https://cdn.ckeditor.com/4.21.0/full/ckeditor.js',
                editorConfig: {
                    language: this.language,
                    skin: 'moono-lisa',
                    filebrowserUploadMethod: 'form',
                    removeButtons: 'NewPage,Save,Font,FontSize,Styles,Flash,Print,Language,Templates,PageBreak',
                    height: 500,
                    filebrowserBrowseUrl: this.filebrowserbrowseurl,
                    filebrowserUploadUrl: this.filebrowseruploadurl,
                    fullPage: true,
	                allowedContent: true
                }
            };
        },
        methods:{
            output: function(data: string){
                this.$emit('output', data);
            }
        }
    });

</script>