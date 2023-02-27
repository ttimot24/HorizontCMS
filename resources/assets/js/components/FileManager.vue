<template>
<section class='container'>

    <section  class='row'>
  
        <div class='col-md-4'>
          <h2>File manager</h2>
        </div>
  
        <div class='col-md-8 text-end mt-4'>
          <div class="row">
              <div class="col-md-4 offset-md-4 col-sm-7 col-xs-7 text-end">
                  <input type="text" v-model="filter" class="form-control" id="filter" placeholder="Filter">
              </div>
              <div class="col text-end">
                <a class='btn btn-primary mr-2' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-target='.upload_file_to_storage'><i class="fa fa-upload" aria-hidden="true"></i> Upload</a>
                <a class='btn btn-primary' data-bs-toggle='modal' data-bs-backdrop='static' data-bs-target='.new_folder'><i class="fa fa-folder" aria-hidden="true"></i> Create Folder</a>
                </div>
          </div>
          
        </div>
  
    </section>
  
    <div class="row">
  
      <div class='panel panel-default col-2 bg-dark p-3'>
          <h4 class="p-2 bg-dark text-white">Drivers</h4>
          <ul class="list-group">
          <!--  @foreach(config('filesystems.disks') as $key => $value)
                  <a href="#" v-on:click.prevent="open('{{ isset($value['root'])? basename($value['root']) : ''}}',false);"><li class="list-group-item bg-dark text-white">{{$key}}</li></a>
            @endforeach -->
          </ul>
      </div>
  
      <div class="panel panel-default col-10 bg-dark" >
        <div class="panel-body">
            <div class="row p-0 m-0">
              <div class="col-md-10 m-0 p-0">
              <nav aria-label="breadcrumb p-0 m-0">
                <ol class="breadcrumb bg-dark p-0 pt-3 m-0">
                  <li class="breadcrumb-item"><a href="storage"  v-on:click.prevent="open('',false);">storage</a></li>
                  <li class="breadcrumb-item" v-for="(bcrumb) in breadcrumb"><a :href="bcrumb.link" v-on:click.prevent="open(bcrumb.link,false);" >@{{bcrumb.text}}</a></li>
                </ol>
              </nav>  
              </div>
              <div class="col-md-2 text-end pt-3 pr-3">
                <div class="row">
                  <div class="col text-white ">All: @{{folders.length + files.length}}</div>
                  <div class="col">
                    <a href="a" v-on:click.prevent="open(currentDirectory,false);"><i class="fa fa-refresh" onclick="$(this).addClass('fa-spin');" aria-hidden="true" style="font-size: 22px;"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div id="workspace" class="col-md-12 py-3 pe-5">
  
              <div class="row text-white">
                <div class='folder col-md-2 col-sm-4 col-xs-4 text-center text-white' v-for="folder in folders" :id="folder" v-on:click="select(folder)" v-on:dblclick="open(folder);" >
                  
                  <div class="file-nav text-end">
                    <a href="#" class="me-1" v-on:click="renameModal(folder)"><i class="fa fa-pencil"></i></a>
                    <a href="#" class="me-1" v-on:click="deleteModal(folder)" ><i class="fa fa-trash"></i></a>
                  </div>
  
                  <div clas='row'>
                    <img style="width:7rem;" src='resources/images/icons/dir.png' >
                  </div>
                  <b>@{{folder}}</b>
                </div>
  
                <div v-for="file in files" class='file col-md-2 col-sm-4 col-xs-4 text-center' :id="file"   @if($mode=='embed') v-on:click="returnFileUrl('storage/'+currentDirectory+'/'+file);" @else v-on:click="select(file)" @endif >
                  <div class="file-nav text-end">
                    <a class="me-1" v-on:click="renameModal(file)"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="me-1" :href="'storage/'+currentDirectory+'/'+file"><i class="fa fa-download"></i></a>
                    <a class="me-1" v-on:click="deleteModal(file)" ><i class="fa fa-trash"></i></a>
                  </div>
                  <img class="w-100 mb-3"  v-if="isKnownExtension(file)" :src="'storage/'+currentDirectory+'/'+file" />
                  <img class="w-100 mb-3"  v-else src="resources/images/icons/file.png" />
                  <b>@{{file}}</b>
                </div>
              </div>
  
            </div>
  
        </div>
      </div>
  
    </div>
  </section>
</template>

<script>

import * as $ from 'jquery';
import "bootstrap";
import "bootstrap-fileinput";
import { defineComponent } from '@vue/composition-api';

export default defineComponent({
	mounted: function(){
    	console.log("VueJS: FileManager started");
        this.open($(this.$el).data('start'),false);
        console.log('Directory: '+this.currentDirectory);
    },
    name: 'FileManager',
    data: function(){
        return {
            _csrfToken: $('[name="_token"]').val(),
            previousDirectory: null,
            currentDirectory: 'storage',
            folders: [],
            files: [],
            knownFileExtensions: ['jpg','png','jpeg'],
            messages: [],
            filter: null,
            selected: null,
        }
    },
    watch:{
        filter: function(filter){
            if(filter != null && filter != ""){
                this.folders = this.folders.filter(folder => folder.includes(filter));
                this.files = this.files.filter(folder => folder.includes(filter));
            }else{
                this.open(this.currentDirectory,false);
            }
        }
    },
    computed: {
        breadcrumb: function(){
            var here = this.currentDirectory.split('/');

            var parts = [];

            for( var i = 0; i < here.length; i++ ) {
                var part = here[i];
                var text = part;
                var link = '' + here.slice( 0, i + 1 ).join('/');
                parts.push({ "text": text, "link": link });
            }

            return parts;
        }
    },
    methods:{
        select: function(file) {
            this.selected = event.currentTarget.id;
            $(".file").removeClass('selected');
            $(".folder").removeClass('selected');
            $(event.currentTarget).addClass('selected');
            console.log('Selected file: '+this.selected);
        },
        open: function(folder, useCurrent = true){

           if(useCurrent){
              var folderToOpen = this.currentDirectory+'/'+folder;
           }else{
              var folderToOpen = folder;
           }

           $.ajax({
                  url: 'admin/file-manager/index',
                  type: 'GET',
                  data:{
                    path: folderToOpen 
                  },
                  success: function (data) {

                    this.previousDirectory = this.currentDirectory;
                    this.currentDirectory = data.current_dir;
                    this.folders = [];
                    this.files = [];

                     console.log(data); 

                     if(typeof data.dirs !== 'undefined' && data.dirs.length > 0){

                         data.dirs.forEach(function(each){
                            this.folders.push(each);
                         });
                     }

                    if(typeof data.files !== 'undefined' && data.files.length > 0){

                      
                        data.files.forEach(function(each){
                            this.files.push(each);
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
    	newFolder: function(event){

    		var dirPath = this.currentDirectory;
    		var folderName = $('[name="new_folder_name"]').val();


    		$.post(event.target.action,
    		{ 
    			_token: this._csrfToken, 
    			dir_path: dirPath,
    			new_folder_name: folderName
    		},
    		function( data ) {
                if(typeof data.success !== 'undefined'){

    			  	console.log("Dir created: "+dirPath+'/'+folderName);
    			  	
                    $('#new_folder').modal('hide');
    			  	$('[name="new_folder_name"]').val("");


                    this.folders.push(folderName);


                }else{
                    console.log("Error:");
                    console.log(data);
                }
			}
			);

    	},
		upload: function(event){

            console.log("Uploading ...");

			var dirPath = this.currentDirectory;

            var fileSelect = $('#input-2');
            var files = fileSelect[0].files;

            var formData = new FormData();
            formData.append('_token',this._csrfToken);
            formData.append('dir_path',dirPath);

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
                     if(typeof data.success !== 'undefined'){
    		              console.log(data);
                          $('#upload_file_to_storage').modal('hide');
                          fileSelect.val("");
                         
                          fileSelect.fileinput("clear");

                          for (var i = 0; i < data.uploadedFileNames.length; i++) {
                                console.log(filemanager.basename(data.uploadedFileNames[i]));
                                this.files.push(filemanager.basename(data.uploadedFileNames[i])+'.'+filemanager.getFileExtension(data.uploadedFileNames[i]));
                          }
                    } else {
                        console.log("Error" +data);
                    }
		          },
		          error: function () {
		              console.log("Error in ajax form submission");
		          }
		      });
		},
		basename: function (url){
		    return ((url=/(([^\/\\\.#\? ]+)(\.\w+)*)([?#].+)?$/.exec(url))!= null)? url[2]: '';
		},
        deleteModal: function(file){
            var modal = $('#delete_sample');
            $($($(modal.find('div.modal-body')).find('div')).find('b')).html(function(event,html){ return filemanager.basename(file); });
            modal.find('a').data('file',file);
            modal.modal('toggle');
        },
        renameModal: function(file){
            this.select(file);
            var modal = $('#rename_sample');
            $("#selected").val(file);
            modal.modal('toggle');
        },
        renameFile: function(event){

            file = this.currentDirectory+'/'+$(event.target).data('old_name');
            console.log(file);

    		$.ajax({
                type: "PUT",
                url: event.target.action,
                contentType: "application/json",
                data: JSON.stringify({ 
                    _token: this._csrfToken, 
                    old_file: this.currentDirectory+'/'+ $('[name="old_name"]').val(),
                    new_file: this.currentDirectory+'/'+$('[name="new_name"]').val()
                }),
                success: function( data ) {
                    if(typeof data.success !== 'undefined'){
                        filemanager.open(this.currentDirectory);
    				    $('#rename_sample').modal('hide');
                    }else{
                        console.log(data);
                    }
              
                }
            });

        },
    	deleteFile: function(event){


    		file = this.currentDirectory+'/'+$(event.target).data('file');


    		$.get('admin/file-manager/destroy',
    		{ 
    			_token: this._csrfToken, 
    			file: file
    		},
    		function( data ) {
    			if(typeof data.success !== 'undefined'){

                    var index = this.files.indexOf($(event.target).data('file'));
                    if (index > -1) {
                      this.files.splice(index, 1);
                    }

                    index = this.folders.indexOf($(event.target).data('file'));
                    if (index > -1) {
                      this.folders.splice(index, 1);
                    }


    				$('#delete_sample').modal('hide');
    			}else{
    				 console.log(data);
    			}
			}
			);

    	},
        getUrlVar: function (location,vary){
            var vars = [], hash;
            var hashes = location.slice(location.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars[vary];
        },
    	getUrlParam: function ( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );

            return ( match && match.length > 1 ) ? match[1] : null;
        },
        returnFileUrl: function (filepath) {
            try{
                // Simulate user action of selecting a file to be returned to CKEditor.
                var funcNum = 1;/*getUrlParam( 'CKEditorFuncNum' );*/
                var fileUrl = filepath;
                window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl, '' );
                window.close();
            } catch(e){
                console.log(funcNum);
                console.log(fileUrl);
                console.log( window.opener.CKEDITOR)
                console.log(e);
            }
        },
        getFileExtension: function(fileName){
            return fileName.substr(fileName.lastIndexOf('.') + 1);
        },
        isKnownExtension: function(fileName){
            return $.inArray( this.getFileExtension(fileName).toLowerCase() , this.knownFileExtensions ) >= 0;
        }
    }

});

</script>