
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
	created: function(){
    	console.log("VueJS: FileManager started");
    },
    el: '#filemanager',
    data:{

    },
    methods:{
      /*  open: function(path){
            $.ajax({
                  url: 'admin/file-manager/index',
                  type: 'GET',
                  data:{
                    path: path
                  },
                  success: function (data) {
                     console.log(data);
                     $('#workspace').empty();

                     filemanager.buildBreadcrumb(path);

                     if(typeof data.dirs !== 'undefined' && data.dirs.length > 0){
                         data.dirs.forEach(function(each){
                            $('#workspace').append(filemanager.createFolder(data.old_path+each));
                         });
                     }

                    if(typeof data.dirs !== 'undefined' && data.dirs.length > 0){
                        data.files.forEach(function(each){
                            $('#workspace').append(filemanager.createFile(data.old_path+each));
                         });

                        }

                  },
                  error: function () {
                      console.log("Error in ajax form submission");
                  }
              });
        },*/
    	dirOpen: function(location){
            console.log("Open: "+location);
    		try{
                filemanager.open(location);
            }catch(error){
               window.location.href = location; 
            }
    	},
    	/*newFolder: function(event){
    		event.preventDefault();

            var token = $('[name="_token"]').val();
    		var dirPath = $('[name="dir_path"]').val();
    		var folderName = $('[name="new_folder_name"]').val();

    		$.post('admin/file-manager/new-folder',
    		{ 
    			_token: token, 
    			dir_path: dirPath,
    			new_folder_name: folderName 
    		},
    		function( data ) {
                if(typeof data.success !== 'undefined'){

    			  	console.log("Dir created: "+dirPath+'/'+folderName);
    			  	
                    $('#new_folder').modal('hide');
    			  	$('[name="new_folder_name"]').val("");

                    folder = filemanager.createFolder(dirPath+'/'+folderName);
                    console.log(folder);
    			  	$('#workspace').append(folder);


                }else{
                    console.log("Error" +data);
                }
			}
			);

    	},
		upload: function(event){
			event.preventDefault();

            console.log("Uploading ...");

			var token = $('[name="_token"]').val();
			var dirPath = $('[name="dir_path"]').val();

            var fileSelect = $('#input-2');
            var files = fileSelect[0].files;

            var formData = new FormData();
            formData.append('_token',token);
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

                          ufile = filemanager.createFile(data.uploadedFileName);
                          console.log(ufile);
                          $('#workspace').append(ufile);
                    }else{
                        console.log("Error" +data);
                    }
		          },
		          error: function () {
		              console.log("Error in ajax form submission");
		          }
		      });
		},*/
		basename: function (url){
		    return ((url=/(([^\/\\\.#\? ]+)(\.\w+)*)([?#].+)?$/.exec(url))!= null)? url[2]: '';
		},
    	/*delete: function(event,file){
    		event.preventDefault();


            token = $('[name="_token"]').val();
    		file = file;


    		$.get('admin/file-manager/delete',
    		{ 
    			_token: token, 
    			file: file
    		},
    		function( data ) {
    			if(typeof data.success !== 'undefined'){
    				$('#'+filemanager.basename(file)).remove();
    				$('#delete_'+filemanager.basename(file)).modal('hide');
    			}else{
    				 console.log(data);
    			}
			}
			);

    	},*/
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
        createFolder: function(fullPath){
            var name = filemanager.basename(fullPath);

            folder = $('<div/>',{
                id: name,
                class: 'folder col-md-2'
            });

            folder[0].ondblclick = function() { filemanager.dirOpen("admin/file-manager/index?path="+fullPath); };

            var navbar = $('<div/>',{
                class: 'file-nav text-right'
            });

            var image = $('<img/>',{
                src: 'resources/images/icons/dir.png'
            });

            navbar.append("<a data-toggle='modal' data-target=.delete_"+name+" ><i class='fa fa-trash pull-right'></i></a>");

            folder.append(navbar);
            folder.append(image);
            folder.append("<b>"+name+"</b>");


            return folder[0];


            //return $('<div/>').html("<div class='folder col-md-2' id='"+name+"' ><div class='file-nav text-right'><a data-toggle='modal' data-target=.delete_"+name+" ><i class='fa fa-trash pull-right'></i></a></div><img src='resources/images/icons/dir.png') ><b>"+name+"</b></div>").contents()[0];
        },
        createFile: function(fullPath){
            
            var name = filemanager.basename(fullPath);

            file = $('<div/>',{
                id: name,
                class: 'file col-md-2'
            });

            var navbar = $('<div/>',{
                class: 'file-nav text-right'
            });

            image = $('<img/>',{
                src: fullPath,
            });

            navbar.append('<a href="admin/file-manager/download?file='+fullPath+'"><i class="fa fa-download"></i></a>&nbsp<a data-toggle="modal" data-target=".delete_'+name+'" ><i class="fa fa-trash"></i></a>');

            file.append(navbar);
            file.append(image);
            file.append('<b>'+name+'</b>');

            return file[0];

            //return $('<div/>').html("<div class='file col-md-2' id="{{str_replace('.'.$file_parts['extension'],'',$file)}}" @if($action=='ckbrowse') onclick='filemanager.returnFileUrl("<?= 'storage/'.$old_path.$file ?>");' @else data-toggle='modal' data-target='.{{$file}}-modal-xl' @endif > <div class="file-nav text-right"><a href="admin/file-manager/download?file=storage/{{$old_path.$file}}"><i class="fa fa-download"></i></a>&nbsp<a data-toggle='modal' data-target=".delete_{{str_replace('.'.$file_parts['extension'],'',$file)}}" ><i class="fa fa-trash"></i></a> </div> @if(isset($file_parts['extension']) && in_array($file_parts['extension'],$allowed_extensions['image'])) <img src="{{'storage/'.$old_path.$file}}"/> @else <img src="resources/images/icons/file.png" style='margin-bottom:5px;' />@endif <b>{{$file}}</b></div>");
        },
        buildBreadcrumb: function(path){
            var breadcrumb = $('.breadcrumb');
            breadcrumb.empty();

            path.split("/").forEach(function(each){
                
                breadcrumb.append(
                    $('<li/>').append(
                        $('<a>').attr('href','/user/messages').innerHTML=each
                    )
                );

            });

        }
    }

});
