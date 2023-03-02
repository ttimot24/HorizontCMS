<template>
  <section id="filemanager" class='container'>

    <section class='row'>

      <div class='col-md-4'>
        <h2>File manager</h2>
      </div>

      <div class='col-md-8 text-end mt-4'>
        <div class="row">
          <div class="col-md-4 offset-md-4 col-sm-7 col-xs-7 text-end">
            <input type="text" v-model="filter" class="form-control" id="filter" placeholder="Filter">
          </div>
          <div class="col text-end">
            <a class='btn btn-primary mr-2' data-bs-toggle='modal' data-bs-backdrop='static'
              data-bs-target='.upload_file_to_storage'><i class="fa fa-upload" aria-hidden="true"></i> Upload</a>
            <a class='btn btn-primary' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-target='.new_folder'><i
                class="fa fa-folder" aria-hidden="true"></i> Create Folder</a>
          </div>
        </div>

      </div>

    </section>

    <div class="row">

      <div class='panel panel-default col-2 bg-dark p-3'>
        <h4 class="p-2 bg-dark text-white">Drivers</h4>
        <ul class="list-group">
          <a href="#" v-for="(driver) in drivers" v-on:click.prevent="open('', false);">
            <li class="list-group-item bg-dark text-white">{{ driver }}</li>
          </a>
        </ul>
      </div>

      <div class="panel panel-default col-10 bg-dark">
        <div class="panel-body">
          <div class="row p-0 m-0">
            <div class="col-md-10 m-0 p-0">
              <nav aria-label="breadcrumb p-0 m-0">
                <ol class="breadcrumb bg-dark p-0 pt-3 m-0">
                  <li class="breadcrumb-item"><a href="storage" v-on:click.prevent="open('', false);">storage</a></li>
                  <li class="breadcrumb-item" v-for="(bcrumb) in breadcrumb"><a :href="bcrumb.link"
                      v-on:click.prevent="open(bcrumb.link, false);">{{ bcrumb.text }}</a></li>
                </ol>
              </nav>
            </div>
            <div class="col-md-2 text-end pt-3 pr-3">
              <div class="row">
                <div class="col text-white ">All: {{ folders.length + files.length }}</div>
                <div class="col">
                  <a href="a" v-on:click.prevent="open(currentDirectory, false);"><i class="fa fa-refresh"
                      onclick="$(vm).addClass('fa-spin');" aria-hidden="true" style="font-size: 22px;"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div id="workspace" class="col-md-12 py-3 pe-5">

            <div class="row text-white">
              <div class='folder col-md-2 col-sm-4 col-xs-4 text-center text-white' v-for="folder in folders" :id="folder"
                v-on:click="select(folder)" v-on:dblclick="open(folder);">

                <div class="file-nav text-end">
                  <a href="#" class="me-1" v-on:click="renameModal(folder)"><i class="fa fa-pencil"></i></a>
                  <a href="#" class="me-1" v-on:click="deleteModal(folder)"><i class="fa fa-trash"></i></a>
                </div>

                <div clas='row'>
                  <img style="width:7rem;" src='resources/images/icons/dir.png'>
                </div>
                <b>{{ folder }}</b>
              </div>

              <div v-for="file in files" class='file col-md-2 col-sm-4 col-xs-4 text-center' :id="file"
                v-on:click="mode == 'embed' ? returnFileUrl('storage/' + currentDirectory + '/' + file) : select(file)">
                <div class="file-nav text-end">
                  <a class="me-1" v-on:click="renameModal(file)"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <a class="me-1" :href="'storage/' + currentDirectory + '/' + file"><i class="fa fa-download"></i></a>
                  <a class="me-1" v-on:click="deleteModal(file)"><i class="fa fa-trash"></i></a>
                </div>
                <img class="w-100 mb-3" v-if="isKnownExtension(file)" :src="'storage/' + currentDirectory + '/' + file" />
                <img class="w-100 mb-3" v-else src="resources/images/icons/file.png" />
                <b>{{ file }}</b>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
  </section>
</template>

<script lang="ts">

import * as $ from 'jquery';
import "bootstrap";
import "bootstrap-fileinput";
import { defineComponent } from '@vue/composition-api';

export default defineComponent({
  name: 'FileManager',
  mounted: function () {
    var vm = this;
    console.log("VueJS: FileManager started");
    vm.open(vm.currentDirectory, false);
    console.log('Directory: ' + vm.currentDirectory);
  },
  data: function () {
    return {
      _csrfToken: $('[name="_token"]').val(),
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
    breadcrumb: function () {
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
    select: function (file: string) {
      var vm = this;

      vm.selected = (event?.currentTarget as any).id;
      $(".file").removeClass('selected');
      $(".folder").removeClass('selected');
      $((event?.currentTarget as any)).addClass('selected');
      console.log('Selected file: ' + vm.selected);
    },
    open: function (folder: string, useCurrent = true) {

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
    newFolder: function (event: any) {

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
          if (typeof data.success !== 'undefined') {

            console.log("Dir created: " + dirPath + '/' + folderName);

            $('#new_folder').modal('hide');
            $('[name="new_folder_name"]').val("");


            vm.folders.push(folderName);


          } else {
            console.log("Error:");
            console.log(data);
          }
        }
      );

    },
    upload: function (event: any) {

      var vm = this;

      console.log("Uploading ...");

      var dirPath = vm.currentDirectory;

      var fileSelect = ($('#input-2') as any);
      var files = fileSelect[0].files;

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
            $('#upload_file_to_storage').modal('hide');
            fileSelect.val("");

            fileSelect.fileinput("clear");

            for (var i = 0; i < data.uploadedFileNames.length; i++) {
              console.log(vm.basename(data.uploadedFileNames[i]));
              vm.files.push(vm.basename(data.uploadedFileNames[i]) + '.' + vm.getFileExtension(data.uploadedFileNames[i]));
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
    basename: function (url: string) {
      return ((/(([^\/\\\.#\? ]+)(\.\w+)*)([?#].+)?$/.exec(url)) != null) ? url[2] : '';
    },
    deleteModal: function (file: string) {
      var vm = this;

      var modal = $('#delete_sample');
      $($($(modal.find('div.modal-body')).find('div')).find('b')).html(function (event, html) { return vm.basename(file); });
      modal.find('a').data('file', file);
      modal.modal('toggle');
    },
    renameModal: function (file: string) {
      var vm = this;

      vm.select(file);
      var modal = $('#rename_sample');
      $("#selected").val(file);
      modal.modal('toggle');
    },
    renameFile: function (event: any) {
      var vm = this;

      var file = vm.currentDirectory + '/' + $(event.target).data('old_name');
      console.log(file);

      $.ajax({
        type: "PUT",
        url: event.target.action,
        contentType: "application/json",
        data: JSON.stringify({
          _token: vm._csrfToken,
          old_file: vm.currentDirectory + '/' + $('[name="old_name"]').val(),
          new_file: vm.currentDirectory + '/' + $('[name="new_name"]').val()
        }),
        success: function (data) {
          if (typeof data.success !== 'undefined') {
            vm.open(vm.currentDirectory);
            $('#rename_sample').modal('hide');
          } else {
            console.log(data);
          }

        }
      });

    },
    deleteFile: function (event: any) {

      var vm = this;

      var file = vm.currentDirectory + '/' + $(event.target).data('file');


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


            $('#delete_sample').modal('hide');
          } else {
            console.log(data);
          }
        }
      );

    },
    getUrlVar: function (location: string, vary: any) {
      var vars = [], hash;
      var hashes = location.slice(location.indexOf('?') + 1).split('&');
      for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[(hash[0] as any)] = hash[1];
      }
      return vars[vary];
    },
    getUrlParam: function (paramName: string) {
      var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
      var match = window.location.search.match(reParam);

      return (match && match.length > 1) ? match[1] : null;
    },
    returnFileUrl: function (filepath: string) {
      try {
        // Simulate user action of selecting a file to be returned to CKEditor.
        var funcNum: number = 1;/*getUrlParam( 'CKEditorFuncNum' );*/
        var fileUrl: string = filepath;
        window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl, '');
        window.close();
      } catch (e) {
        console.log(window.opener.CKEDITOR)
        console.log(e);
      }
    },
    getFileExtension: function (fileName: string) {
      return fileName.substr(fileName.lastIndexOf('.') + 1);
    },
    isKnownExtension: function (fileName: string) {
      var vm = this;

      return $.inArray(vm.getFileExtension(fileName).toLowerCase(), vm.knownFileExtensions) >= 0;
    }
  }

});

</script>