
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

//Vue.component('example', require('./components/Example.vue'));


var filemanager = new Vue({
	mounted: function(){
    	console.log("VueJS: FileManager started");
        this.open($(this.$el).data('start'),false);
        console.log('Directory: '+this.$data.currentDirectory);
    },
    name: 'FileManager',
    el: '#filemanager',
    data:{
        _csrfToken: $('[name="_token"]').val(),
        previousDirectory: null,
        currentDirectory: 'storage',
        folders: [],
        files: [],
        knownFileExtensions: ['jpg','png','jpeg'],
        messages: [],
        filter: null,
    },
    watch:{
        filter: function(filter){
            if(filter != null && filter != ""){
                this.$data.folders = this.$data.folders.filter(folder => folder.includes(filter));
                this.$data.files = this.$data.files.filter(folder => folder.includes(filter));
            }else{
                this.open(this.$data.currentDirectory,false);
            }
        }
    },
    computed: {
        breadcrumb: function(){
            var here = this.$data.currentDirectory.split('/');

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
        open: function(folder, useCurrent = true){

           if(useCurrent){
              var folderToOpen = this.$data.currentDirectory+'/'+folder;
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

                    filemanager.$data.previousDirectory = filemanager.$data.currentDirectory;
                    filemanager.$data.currentDirectory = data.current_dir;
                    filemanager.$data.folders = [];
                    filemanager.$data.files = [];

                     console.log(data); 

                     if(typeof data.dirs !== 'undefined' && data.dirs.length > 0){

                         data.dirs.forEach(function(each){
                            filemanager.$data.folders.push(each);
                         });
                     }

                    if(typeof data.files !== 'undefined' && data.files.length > 0){

                      
                        data.files.forEach(function(each){
                            filemanager.$data.files.push(each);
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
    	newFolder: function(){

    		var dirPath = this.$data.currentDirectory;
    		var folderName = $('[name="new_folder_name"]').val();


    		$.post('admin/file-manager/new-folder',
    		{ 
    			_token: filemanager.$data._csrfToken, 
    			dir_path: dirPath,
    			new_folder_name: folderName
    		},
    		function( data ) {
                if(typeof data.success !== 'undefined'){

    			  	console.log("Dir created: "+dirPath+'/'+folderName);
    			  	
                    $('#new_folder').modal('hide');
    			  	$('[name="new_folder_name"]').val("");


                    filemanager.$data.folders.push(folderName);


                }else{
                    console.log("Error:");
                    console.log(data);
                }
			}
			);

    	},
		upload: function(){

            console.log("Uploading ...");

			var dirPath = filemanager.$data.currentDirectory;

            var fileSelect = $('#input-2');
            var files = fileSelect[0].files;

            var formData = new FormData();
            formData.append('_token',filemanager.$data._csrfToken);
            formData.append('dir_path',dirPath);

            for (var i = 0; i < files.length; i++) {
              var file = files[i];
              formData.append('up_file[]', file, file.name);
            }


		      $.ajax({
		          url: 'admin/file-manager/fileupload',
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
                                filemanager.$data.files.push(filemanager.basename(data.uploadedFileNames[i])+'.'+filemanager.getFileExtension(data.uploadedFileNames[i]));
                          }
                    }else{
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
        modal: function(file){
            var modal = $('#delete_sample');
            $($($(modal.find('div.modal-body')).find('div')).find('b')).html(function(event,html){ return filemanager.basename(file); });
            modal.find('a').data('file',file);
            modal.modal('toggle');
        },
    	deleteFile: function(event){


    		file = filemanager.$data.currentDirectory+'/'+$(event.target).data('file');


    		$.get('admin/file-manager/delete',
    		{ 
    			_token: filemanager.$data._csrfToken, 
    			file: file
    		},
    		function( data ) {
    			if(typeof data.success !== 'undefined'){

                    var index = filemanager.$data.files.indexOf($(event.target).data('file'));
                    if (index > -1) {
                      filemanager.$data.files.splice(index, 1);
                    }

                    index = filemanager.$data.folders.indexOf($(event.target).data('file'));
                    if (index > -1) {
                      filemanager.$data.folders.splice(index, 1);
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
        	// Simulate user action of selecting a file to be returned to CKEditor.
            var funcNum = 1;/*getUrlParam( 'CKEditorFuncNum' );*/
            var fileUrl = filepath;
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        },
        getFileExtension: function(fileName){
            return fileName.substr(fileName.lastIndexOf('.') + 1);
        },
        isKnownExtension: function(fileName){
            return $.inArray( this.getFileExtension(fileName).toLowerCase() , this.$data.knownFileExtensions ) >= 0;
        }
    }

});
