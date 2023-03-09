<template>
    <div id="text-editor">
        <textarea style="display: none;" v-model="data" :name="name" ></textarea>
        <ckeditor v-model="content" :tag-name="'textarea'" :name="name" :config="editorConfig"></ckeditor>
    </div>
</template>

<script lang="ts">

	import { defineComponent } from '@vue/composition-api';

	export default defineComponent({
        name: 'text-editor',
        props: {
            name: String,
            data: String,
            language: String,
            filebrowserbrowseurl: String,
            filebrowseruploadurl: String,
        },
        data: function() {
            return {
                content: this.data,
                editorConfig: {
                    language: this.language,
                    skin: 'moono-lisa',
                    filebrowserUploadMethod: 'form',
                    removeButtons: 'NewPage,Save,Font,FontSize,Styles,Flash,Print,Language,Templates,PageBreak',
                    height: 500,
                    filebrowserBrowseUrl: this.filebrowserbrowseurl,
                    filebrowserUploadUrl: this.filebrowseruploadurl
                }
            };
        }
    });

</script>
