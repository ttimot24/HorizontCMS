<template>
    <div id="filemanager">

        <section class='container'>

            <div class="card mb-3">
                <div class="card-header fw-bold">

                    <section class='row'>

                        <div class='col-md-4'>
                            <h2>File manager</h2>
                        </div>

                        <div class='col-md-8 text-end mt-4'>
                            <div class="row">
                                <div class="col-md-4 offset-md-3 col-sm-7 col-xs-7 text-end">
                                    <input type="text" v-model="filter" class="form-control" id="filter"
                                        placeholder="Filter">
                                </div>
                                <div class="col text-end">
                                    <a class='btn btn-primary mr-2' data-bs-toggle='modal' data-bs-backdrop='static'
                                        data-bs-target='.upload_file_to_storage'><i class="fa fa-upload"
                                            aria-hidden="true"></i>
                                        Upload</a>
                                    <a class='btn btn-primary' data-bs-toggle='modal' data-bs-backdrop='static'
                                        data-bs-target='.new_folder'><i class="fa fa-folder" aria-hidden="true"></i> Create
                                        Folder</a>
                                </div>
                            </div>

                        </div>

                    </section>

                </div>

                <div class="card-body container py-0">

                    <div class="row">

                        <div class='panel panel-default col-2 bg-dark p-3' style="min-height:500px;">
                            <h4 class="p-2 bg-dark text-white">Drivers</h4>
                            <ul class="list-group">

                                <!-- v-on:click.prevent="open('{{ isset($value['root']) ? basename($value['root']) : '' }}', false);" -->
                                <a href="#" v-for="(disk) in disks" v-on:click.prevent="open(disk, false)">
                                    <li class="list-group-item bg-dark text-white">{{ disk }}</li>
                                </a>

                            </ul>
                        </div>

                        <div class="panel panel-default col-10 bg-dark">
                            <div class="panel-body">
                                <div class="row p-0 m-0">
                                    <div class="col-md-10 m-0 p-0">
                                        <nav aria-label="breadcrumb p-0 m-0">
                                            <ol class="breadcrumb bg-dark p-0 pt-3 m-0">
                                                <li class="breadcrumb-item"><a href="storage"
                                                        v-on:click.prevent="open('', false); ">storage</a></li>
                                                <li class="breadcrumb-item" v-for="(  bcrumb  ) in   breadcrumb  "><a
                                                        :href=" bcrumb.link "
                                                        v-on:click.prevent=" open(bcrumb.link, false); ">{{ bcrumb.text
                                                        }}</a>
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                    <div class="col-md-2 text-end pt-3 pr-3">
                                        <div class="row">
                                            <div class="col text-white ">All: {{ folders.length + files.length }}</div>
                                            <div class="col">
                                                <a href="a" v-on:click.prevent=" open(currentDirectory, false); "><i
                                                        class="fa fa-refresh" onclick="$(this).addClass('fa-spin');"
                                                        aria-hidden="true" style="font-size: 22px;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="workspace" class="col-md-12 py-3 pe-5">

                                    <div class="row text-white">
                                        <div class='folder col-md-2 col-sm-4 col-xs-4 text-center text-white'
                                            v-for="  folder   in   folders  " :id=" folder " v-on:click=" select(folder) "
                                            v-on:dblclick=" open(folder); ">

                                            <div class="file-nav text-end">
                                                <a class="me-1" v-on:click=" renameModal(folder) "><i
                                                        class="fa fa-pencil"></i></a>
                                                <a class="me-1" v-on:click=" deleteModal(folder) "><i
                                                        class="fa fa-trash"></i></a>
                                            </div>

                                            <div clas='row'>
                                                <img style="width:7rem;" src='resources/images/icons/dir.png'>
                                            </div>
                                            <b>{{ folder }}</b>
                                        </div>

                                        <div v-for="  file   in  files " class='file col-md-2 col-sm-4 col-xs-4 text-center'
                                            :id=" file " v-on:click="
                                                mode === 'embed' ?
                                                    returnFileUrl('storage/' + currentDirectory + '/' + file) :
                                                    select(file)
                                            ">
                                            <div class="file-nav text-end">
                                                <a class="me-1" v-on:click=" renameModal(file) "><i class="fa fa-pencil"
                                                        aria-hidden="true"></i></a>
                                                <a class="me-1" :href=" 'storage/' + currentDirectory + '/' + file "><i
                                                        class="fa fa-download"></i></a>
                                                <a class="me-1" v-on:click=" deleteModal(file) "><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                            <img class="w-100 mb-3" v-if=" isKnownExtension(file) "
                                                :src=" 'storage/' + currentDirectory + '/' + file " />
                                            <img class="w-100 mb-3" v-else src="resources/images/icons/file.png" />
                                            <b>{{ file }}</b>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>



    <div class='modal new_folder' id='new_folder' tabindex='-1' role='dialog' aria-labelledby='new_folder'
        aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header modal-header-primary bg-primary'>
                    <h4 class='modal-title text-white'>Create new folder</h4>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>

                <form action='admin/file-manager/new-folder' method='POST' enctype='multipart/form-data'
                    v-on:submit.prevent=" newFolder ">
                    <div class='modal-body'>
                        <div class='form-group'>
                            <div class='form-group'>
                                <label for='title'>Name:</label>
                                <input type='text' class='form-control' name='new_folder_name'
                                    placeholder='Enter folder name' required>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Create</button>
                        <button type='button' class='btn btn-default' data-bs-dismiss='modal'>Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class='modal rename_modal' id='rename_sample' tabindex='-1' role='dialog' aria-labelledby='rename_file'
        aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header modal-header-primary'>
                    <h4 class='modal-title'>Rename</h4>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>

                <form action='admin/file-manager/rename' method='POST' v-on:submit.prevent=" renameFile ">
                    <div class='modal-body'>

                        <div class='form-group'>
                            <div class='form-group'>
                                <label for='title'>Selected:</label>
                                <input type='text' class='form-control' name='old_name' id="selected" disabled>
                            </div>
                        </div>

                        <div class='form-group'>
                            <div class='form-group'>
                                <label for='title'>New name:</label>
                                <input type='text' class='form-control' name='new_name' id="selected" required>
                            </div>
                        </div>


                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Rename</button>
                        <button type='button' class='btn btn-default' data-bs-dismiss='modal'>Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class='modal upload_file_to_storage' id='upload_file_to_storage' tabindex='-1' role='dialog'
        aria-labelledby='upload_file_to_storage' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header modal-header-primary bg-primary'>
                    <h4 class='modal-title text-white'>Upload file</h4>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>

                <form action="admin/filemanager" method='POST' enctype='multipart/form-data'
                    v-on:submit.prevent="upload">
                    <div class='modal-body'>


                        <div class='form-group'>
                            <label for='file'>Upload file:</label>
                            <input name='up_file[]' id='input-2' type='file' class='file' multiple='true'
                                data-show-upload='false' data-show-caption='true' required>
                        </div>

                    </div>
                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Upload</button>
                        <button type='button' class='btn btn-default'
                            data-bs-dismiss='modal'>Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <delete-modal :id="'delete_sample'" :route="'admin/file-manager/destroy'" :header="'Are you sure you want to delete?'" :name="'[dir_name_sample]'" :delete_text="'Delete'" :cancel="'Cancel'" ref="deletemodal"></delete-modal>

    </div>

</template>

<script lang="ts">

import { defineComponent } from '@vue/composition-api';
import DeleteModal from './DeleteModal.vue';

export default defineComponent({
    name: 'FileManager',
    components: {
        DeleteModal
    },
    mounted: function () {

        var vm = this;

        console.log("VueJS: FileManager started");
        vm.open(this.currentDirectory, false);
        console.log('Directory: ' + vm.currentDirectory);


        vm.modalRename = vm.getModal("rename_sample");
        vm.modalUpload = vm.getModal("upload_file_to_storage");
        vm.modalNewFolder = vm.getModal("new_folder");
        vm.modalDelete = vm.getModal("delete_sample");

        $('#delete-form').on('submit', (event: Event) => { event.preventDefault(); this.deleteFile(); });
    },
    inject: ['bootstrap'],
    props: {
        directory: {
            type: String,
            default: ''
        },
        disks: {
            type: Array<string>,
            default: []
        },
        mode: {
            type: String,
            default: 'standalone'
        }
    },
    data: function () {
        return {
            mode: this.mode,
            previousDirectory: null,
            currentDirectory: this.directory,
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
        getModal: function (id: string): bootstrap.Modal {
            return (new this.bootstrap.Modal(document.getElementById(id) || {} as HTMLElement));
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
                success: function (data: any) {

                    vm.previousDirectory = vm.currentDirectory;
                    vm.currentDirectory = data.current_dir;
                    vm.folders = [];
                    vm.files = [];

                    console.log(data);

                    if (typeof data.dirs !== undefined && data.dirs.length > 0) {

                        data.dirs.forEach(function (each: string) {
                            vm.folders.push(each);
                        });
                    }

                    if (typeof data.files !== undefined && data.files.length > 0) {


                        data.files.forEach(function (each: string) {
                            vm.files.push(each);
                        });

                    }

                    $('.fa-refresh').removeClass('fa-spin');
                },
                error: function (data: any) {
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
                    _token: vm.csrfToken,
                    dir_path: dirPath,
                    new_folder_name: folderName
                },
                function (data: any) {
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

            event.preventDefault();

            var vm = this;

            console.log("Uploading ...");

            var dirPath = vm.currentDirectory;

            var fileSelect = ($('#input-2') as any);
            var files = fileSelect[0].files;

            if (!files) {
                console.log("No file is selected");
                return;
            }

            var formData = new FormData();
            formData.append('_token', vm.csrfToken);
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
                success: function (data: any) {
                    if (typeof data.success !== undefined) {
                        console.log(data);

                        vm.modalUpload.hide();

                        fileSelect.val("");

                        //fileSelect.fileinput("clear");

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
            //return ((/(([^\/\\\.#\? ]+)(\.\w+)*)([?#].+)?$/.exec(url)) != null) ? url[2] : '';
            return url.substring(url.lastIndexOf('/') + 1);
        },
        deleteModal: function (file: string): void {
            var vm = this;

            $('#content-name').text(vm.basename(file));

            $("#delete-submit").data('file', file);

            vm.modalDelete.show();

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
                    _token: vm.csrfToken,
                    old_file: vm.currentDirectory.concat('/').concat($('[name="old_name"]').val()),
                    new_file: vm.currentDirectory.concat('/').concat($('[name="new_name"]').val())
                }),
                success: function (data: any) {
                    if (typeof data.success !== undefined) {
                        vm.open(vm.currentDirectory);
                        vm.modalRename.hide();
                        $('[name="new_name"]').val('');
                    } else {
                        console.log(data);
                    }

                }
            });

        },
        deleteFile: function (): void {

            var vm = this;

            var deleteSubmit = $("#delete-submit");

            var file = vm.currentDirectory.concat('/').concat(deleteSubmit.data('file'));


            $.post('admin/file-manager/destroy',
                {
                    _token: vm.csrfToken,
                    file: file
                },
                function (data: any) {
                    if (typeof data.success !== undefined) {

                        var index = vm.files.indexOf(deleteSubmit.data('file'));
                        if (index > -1) {
                            vm.files.splice(index, 1);
                        }

                        index = vm.folders.indexOf(deleteSubmit.data('file'));
                        if (index > -1) {
                            vm.folders.splice(index, 1);
                        }

                        vm.modalDelete.hide();

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
        getUrlParam: function (paramName: string): number {
            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);

            return Number((match && match.length > 1) ? match[1] : null);
        },
        returnFileUrl: function (filepath: string): void {

            try {
                // Simulate user action of selecting a file to be returned to CKEditor.
                var funcNum: number = this.getUrlParam("CKEditorFuncNum");
                var fileUrl: string = window.location.protocol + '//' +window.location.host+'/'+filepath;
                window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl, '');
                window.close();
            } catch (e) {
                console.log(window.opener.CKEDITOR)
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

</script>