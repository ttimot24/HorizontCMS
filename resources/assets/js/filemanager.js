
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
    	dirOpen: function(location){
    		window.location.href = location;
    	},
    	/*newFolder: function(event){
    		event.preventDefault();

    		token = $('[name="_token"]').val();
    		dirPath = $('[name="dir_path"]').val();
    		folderName = $('[name="new_folder_name"]').val();

    		$.post('admin/file-manager/new-folder',
    		{ 
    			_token: token, 
    			dir_path: dirPath,
    			new_folder_name: folderName 
    		},
    		function( data ) {
			  	console.log("Dir created: "+dirPath+'/'+folderName);
			  	$('#new_folder').modal('hide');
			  	$('[name="new_folder_name"]').val("");
			  	$( "<img src='resources/images/icons/dir.png'><b>"+folderName+"</b>" ).appendTo( ".workspace" );
			}
			);

    	},*/
		/*upload: function(event){
			event.preventDefault();

			var token = $('[name="_token"]').val();
			var dirPath = $('[name="dir_path"]').val();
			var dirPath = $('[name="dir_path"]').val();


		      $.ajax({
		          url: 'admin/file-manager/fileupload',
		          type: 'POST',
		          enctype: 'multipart/form-data',
		          data: data,
		          async: false,
		          cache: false,
		          contentType: false,
		          processData: false,
		          success: function (data) {
		              alert(data);
		          },
		          error: function () {
		              alert("error in ajax form submission");
		          }
		      });
		},*/
		

		basename: function (url){
		    return ((url=/(([^\/\\\.#\? ]+)(\.\w+)*)([?#].+)?$/.exec(url))!= null)? url[2]: '';
		},
    	delete: function(event,file){
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
        }
    }

});
