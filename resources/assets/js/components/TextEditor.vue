<template>
    <div id="text-editor">
        <textarea style="display: none;" v-model="data" :name="name" ></textarea>
        <ckeditor v-model="data" :tag-name="'textarea'" :name="name" :config="editorConfig"></ckeditor>
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
                editorConfig: {
                    language: 'en',
                    skin: 'moono-lisa',
                    filebrowserUploadMethod: 'form',
                    removeButtons: 'NewPage,Save,Font,FontSize,Styles,Flash,Print,Language,Templates,PageBreak',
                    height: 500,
                    filebrowserBrowseUrl: 'admin/file-manager/index?path=images/pages&mode=embed',
                    filebrowserUploadUrl: 'admin/file-manager/upload?module=pages'
                }
            };
        }
    });

</script>
