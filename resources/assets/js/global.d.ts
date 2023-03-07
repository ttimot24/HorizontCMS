import { VueConstructor } from "vue";

export {};

declare global {
    interface Window {
        $: any,
        vue: VueConstructor<Vue>;
        CKEDITOR: any,
        bootstrap: any;
        lockscreen: LockScreen;
        filemanager: FileManager;
        texteditor: TextEditor;
    }
}