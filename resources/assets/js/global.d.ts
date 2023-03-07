import { VueConstructor } from "vue";

export {};

declare global {
    interface Window {
        $: any,
        vue: VueConstructor<Vue>;
        bootstrap: any;
        lockscreen: LockScreen;
        filemanager: FileManager;
        texteditor: TextEditor;
    }
}