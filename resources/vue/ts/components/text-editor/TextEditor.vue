<template>
    <div id="text-editor">
        <textarea style="display: none;" v-model="content" :name="name" ></textarea>
        <ckeditor @input="output" v-model="content" :tag-name="'textarea'" :name="name" :config="editorConfig" :editor-url="editorUrl"></ckeditor>
    </div>
</template>

<script lang="ts" src="./TextEditor.ts" />