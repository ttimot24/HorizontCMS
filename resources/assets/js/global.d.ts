export {};

declare global {
    interface Window {
        vue: VueConstructor<Vue>;
        lockscreen: LockScreen;
        filemanager: FileManager;
        texteditor: TextEditor;
    }
}