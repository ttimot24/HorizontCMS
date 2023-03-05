import * as $ from 'jquery';
import Vue from 'vue';
import { Modal } from 'bootstrap';
import CKEDITOR from 'ckeditor4-vue';

var fileamanager = new Vue({
    name: 'FileManager',
    el: '#filemanager',
    mounted: function () {
        var vm = this;
        vm._csrfToken = $('[name="_token"]').val();

        vm.modalRename = vm.getModal("rename_sample");
        vm.modalUpload = vm.getModal("upload_file_to_storage");
        vm.modalNewFolder = vm.getModal("new_folder");

        console.log("VueJS: FileManager started");
        vm.open(vm.currentDirectory, false);
        console.log('Directory: ' + vm.currentDirectory);
    },
    data: function () {
        return {
            _csrfToken: '',
            mode: 'embed',
            previousDirectory: null,
            currentDirectory: '',
            drivers: [],
            folders: [],
            files: [],
            knownFileExtensions: ['jpg', 'png', 'jpeg'],
            messages: [],
            filter: null,
            selected: null,
        }
    },
    watch: {
        filter: function (filter) {
            var vm = this;

            if (filter != null && filter != "") {
                vm.folders = vm.folders.filter((folder: string) => folder.includes(filter));
                vm.files = vm.files.filter((folder: string) => folder.includes(filter));
            } else {
                vm.open(vm.currentDirectory, false);
            }
        }
    },
    computed: {
        breadcrumb: function (): {
            text: any,
            link: string
        }[] {
            var vm = this;

            var here = vm.currentDirectory.split('/');

            var parts = [];

            for (var i = 0; i < here.length; i++) {
                var part = here[i];
                var text = part;
                var link = '' + here.slice(0, i + 1).join('/');
                parts.push({ "text": text, "link": link });
            }

            return parts;
        }
    },
    methods: {
        getModal: function(id: string): Modal {
            return  (new Modal(document.getElementById(id) || {} as HTMLElement));
        },
        select: function (file: string): void {
            var vm = this;

            vm.selected = (event?.currentTarget as any).id;
            $(".file").removeClass('selected');
            $(".folder").removeClass('selected');
            $((event?.currentTarget as any)).addClass('selected');
            console.log('Selected file: ' + vm.selected);
        },
        open: function (folder: string, useCurrent = true): void {

            var vm = this;

            if (useCurrent) {
                var folderToOpen = vm.currentDirectory + '/' + folder;
            } else {
                var folderToOpen = folder;
            }

            $.ajax({
                url: 'admin/file-manager/index',
                type: 'GET',
                data: {
                    path: folderToOpen
                },
                success: function (data) {

                    vm.previousDirectory = vm.currentDirectory;
                    vm.currentDirectory = data.current_dir;
                    vm.folders = [];
                    vm.files = [];

                    console.log(data);

                    if (typeof data.dirs !== 'undefined' && data.dirs.length > 0) {

                        data.dirs.forEach(function (each: string) {
                            vm.folders.push(each);
                        });
                    }

                    if (typeof data.files !== 'undefined' && data.files.length > 0) {


                        data.files.forEach(function (each: string) {
                            vm.files.push(each);
                        });

                    }

                    $('.fa-refresh').removeClass('fa-spin');
                },
                error: function (data) {
                    console.log(data);
                    //  throw "Error in ajax form submission";
                }
            });

        },
        newFolder: function (event: any): void {

            var vm = this;

            var dirPath = vm.currentDirectory;
            var folderName = $('[name="new_folder_name"]').val();


            $.post(event.target.action,
                {
                    _token: vm._csrfToken,
                    dir_path: dirPath,
                    new_folder_name: folderName
                },
                function (data) {
                    if (typeof data.success !== undefined) {

                        console.log("Dir created: " + dirPath + '/' + folderName);

                        vm.modalNewFolder.hide();

                        $('[name="new_folder_name"]').val("");

                        vm.folders.push(folderName);


                    } else {
                        console.log("Error:");
                        console.log(data);
                    }
                }
            );

        },
        upload: function (event: any): void {

            var vm = this;

            console.log("Uploading ...");

            var dirPath = vm.currentDirectory;

            var fileSelect = ($('#input-2') as any);
            var files = fileSelect[0].files;

            if(!files){
                console.log("No file is selected");
                return;
            }

            var formData = new FormData();
            formData.append('_token', vm._csrfToken);
            formData.append('dir_path', dirPath);

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                formData.append('up_file[]', file, file.name);
            }


            $.ajax({
                url: event.target.action,
                type: 'POST',
                enctype: 'multipart/form-data',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (typeof data.success !== 'undefined') {
                        console.log(data);

                        vm.modalUpload.hide();

                        fileSelect.val("");

                        fileSelect.fileinput("clear");

                        for (var i = 0; i < data.uploadedFileNames.length; i++) {
                            console.log(vm.basename(data.uploadedFileNames[i]));
                            vm.files.push(vm.basename(data.uploadedFileNames[i]).concat('.').concat(vm.getFileExtension(data.uploadedFileNames[i])));
                        }
                    } else {
                        console.log("Error" + data);
                    }
                },
                error: function () {
                    console.log("Error in ajax form submission");
                }
            });
        },
        basename: function (url: string): string {
            return ((/(([^\/\\\.#\? ]+)(\.\w+)*)([?#].+)?$/.exec(url)) != null) ? url[2] : '';
        },
        deleteModal: function (file: string): void {
            var vm = this;

            var modal = $('#delete_sample');
            $($($(modal.find('div.modal-body')).find('p')).find('b')).html(function (event, html) { return vm.basename(file); });
            modal.find('a').data('file', file);

            vm.getModal(modal.get(0)).show();

        },
        renameModal: function (file: string): void {
            var vm = this;

            vm.select(file);
            $("#selected").val(file);
            vm.modalRename.show();
        },
        renameFile: function (event: any): void {
            var vm = this;

            var file = vm.currentDirectory.concat('/').concat($('[name="old_name"]').val());
            console.log(file);

            $.ajax({
                type: "PUT",
                url: event.target.action,
                contentType: "application/json",
                data: JSON.stringify({
                    _token: vm._csrfToken,
                    old_file: vm.currentDirectory.concat('/').concat($('[name="old_name"]').val()),
                    new_file: vm.currentDirectory.concat('/').concat($('[name="new_name"]').val())
                }),
                success: function (data) {
                    if (typeof data.success !== 'undefined') {
                        vm.open(vm.currentDirectory);
                        vm.modalRename.hide();
                    } else {
                        console.log(data);
                    }

                }
            });

        },
        deleteFile: function (event: any): void {

            var vm = this;

            var file = vm.currentDirectory.concat('/').concat($(event.target).data('file'));


            $.get('admin/file-manager/destroy',
                {
                    _token: vm._csrfToken,
                    file: file
                },
                function (data) {
                    if (typeof data.success !== 'undefined') {

                        var index = vm.files.indexOf($(event.target).data('file'));
                        if (index > -1) {
                            vm.files.splice(index, 1);
                        }

                        index = vm.folders.indexOf($(event.target).data('file'));
                        if (index > -1) {
                            vm.folders.splice(index, 1);
                        }

                        var modal = vm.getModal('delete_sample');
                        modal.hide();

                    } else {
                        console.log(data);
                    }
                }
            );

        },
        getUrlVar: function (location: string, vary: any): any {
            var vars = [], hash;
            var hashes = location.slice(location.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[(hash[0] as any)] = hash[1];
            }
            return vars[vary];
        },
        getUrlParam: function (paramName: string): string | null {
            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);

            return (match && match.length > 1) ? match[1] : null;
        },
        returnFileUrl: function (filepath: string): void {

            console.log(CKEDITOR);

            try {
                // Simulate user action of selecting a file to be returned to CKEditor.
                var funcNum: number = 1;/*getUrlParam( 'CKEditorFuncNum' );*/
                var fileUrl: string = filepath;
                CKEDITOR.tools.callFunction(funcNum, fileUrl, '');
                window.close();
            } catch (e) {
                console.log(CKEDITOR)
                console.log(e);
            }
        },
        getFileExtension: function (fileName: string): string {
            return fileName.substring(fileName.lastIndexOf('.') + 1);
        },
        isKnownExtension: function (fileName: string): boolean {
            var vm = this;

            return vm.knownFileExtensions.includes(vm.getFileExtension(fileName).toLowerCase());
        }
    }

});
