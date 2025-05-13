export interface FileManagerResponse {
    old_path?: string;
    current_dir: string;
    dirs: string[];
    files: string[];
    allowed_extensions?: {
        image?: string[];
    };
    mode?: string | null;
}