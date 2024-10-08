<template>
    <div id="text-editor">
        <textarea style="display: none;" v-model="content" :name="name" ></textarea>
        <ckeditor @input="output" v-model="content" :tag-name="'textarea'" :name="name" :config="editorConfig" :editor-url="editorUrl"></ckeditor>
    </div>
</template>

<script lang="ts">

	import { defineComponent } from '@vue/composition-api';
    import { environment } from '../environments/environment';

	export default defineComponent({
        name: 'text-editor',
        props: {
            name: {
                type: String,
                default: '',
                required: true
            },
            data: { 
                type: String
            },
            language: {
                type: String,
                default: 'en'
            },
            filebrowserbrowseurl: {
                type: String
            },
            filebrowseruploadurl: {
                type: String
            },
            height: {
                type: Number,
                default: 500
            }
        },
        data: function() {
            return {
                content: this.data,
                editorUrl: 'https://cdn.ckeditor.com/'+environment.CKEDITOR_VERSION+'/full/ckeditor.js',
                editorConfig: {
                    versionCheck: false,
                    language: this.language,
                    skin: 'moono-lisa',
                    filebrowserUploadMethod: 'form',
                    removeButtons: 'NewPage,Save,Font,FontSize,Styles,Flash,Print,Language,Templates,PageBreak',
                    height: this.height,
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