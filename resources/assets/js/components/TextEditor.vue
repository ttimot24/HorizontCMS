<template>
    <div id="text-editor">
        <textarea style="display: none;" v-model="data" :name="name" ></textarea>
        <ckeditor v-model="data" :tag-name="'textarea'" :name="name" :config="config" :editor-url="editorUrl"></ckeditor>
    </div>
</template>

<script lang="ts">

	import { defineComponent } from '@vue/composition-api';

	export default defineComponent({
        name: 'text-editor',
        props: {
            name: String,
            data: String
        },
        data: function() {
            return {
                editorUrl: 'https://cdn.ckeditor.com/4.20.2/full-all/ckeditor.js',
                config: {
                    skin: 'moono-lisa',
                    filebrowserUploadMethod: 'form',
                    removeButtons: 'NewPage,Save,Font,FontSize,Styles,Flash,Print,Language,Templates,PageBreak',
                    height: 500,
                }
            };
        }
    });

</script>
