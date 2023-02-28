<template>
    <div id="text-editor">
        <ckeditor v-model="editorData" :config="editorConfig"></ckeditor>
    </div>
</template>

<script lang="ts">

	import { defineComponent } from '@vue/composition-api';

	export default defineComponent({
        name: 'text-editor',
        data: function() {
            return {
                editorData: '',
                editorConfig: {
                    skin: 'moono-lisa',
                    filebrowserUploadMethod: 'form',
                    removeButtons: 'NewPage,Save,Font,FontSize,Styles,Flash,Print,Language,Templates,PageBreak',
                    height: 500,
                }
            };
        }
    });

</script>
