/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/filemanager.js":
/*!********************************************!*\
  !*** ./resources/assets/js/filemanager.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

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
  mounted: function mounted() {
    console.log("VueJS: FileManager started");
    this.open($(this.$el).data('start'), false);
    console.log('Directory: ' + this.$data.currentDirectory);
  },
  name: 'FileManager',
  el: '#filemanager',
  data: {
    _csrfToken: $('[name="_token"]').val(),
    previousDirectory: null,
    currentDirectory: 'storage',
    folders: [],
    files: [],
    knownFileExtensions: ['jpg', 'png', 'jpeg'],
    messages: [],
    filter: null,
    selected: null
  },
  watch: {
    filter: function filter(_filter) {
      if (_filter != null && _filter != "") {
        this.$data.folders = this.$data.folders.filter(function (folder) {
          return folder.includes(_filter);
        });
        this.$data.files = this.$data.files.filter(function (folder) {
          return folder.includes(_filter);
        });
      } else {
        this.open(this.$data.currentDirectory, false);
      }
    }
  },
  computed: {
    breadcrumb: function breadcrumb() {
      var here = this.$data.currentDirectory.split('/');
      var parts = [];

      for (var i = 0; i < here.length; i++) {
        var part = here[i];
        var text = part;
        var link = '' + here.slice(0, i + 1).join('/');
        parts.push({
          "text": text,
          "link": link
        });
      }

      return parts;
    }
  },
  methods: {
    select: function select(file) {
      this.$data.selected = event.currentTarget.id;
      $(".file").removeClass('selected');
      $(".folder").removeClass('selected');
      $(event.currentTarget).addClass('selected');
      console.log('Selected file: ' + filemanager.$data.selected);
    },
    open: function open(folder) {
      var useCurrent = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

      if (useCurrent) {
        var folderToOpen = this.$data.currentDirectory + '/' + folder;
      } else {
        var folderToOpen = folder;
      }

      $.ajax({
        url: 'admin/file-manager/index',
        type: 'GET',
        data: {
          path: folderToOpen
        },
        success: function success(data) {
          filemanager.$data.previousDirectory = filemanager.$data.currentDirectory;
          filemanager.$data.currentDirectory = data.current_dir;
          filemanager.$data.folders = [];
          filemanager.$data.files = [];
          console.log(data);

          if (typeof data.dirs !== 'undefined' && data.dirs.length > 0) {
            data.dirs.forEach(function (each) {
              filemanager.$data.folders.push(each);
            });
          }

          if (typeof data.files !== 'undefined' && data.files.length > 0) {
            data.files.forEach(function (each) {
              filemanager.$data.files.push(each);
            });
          }

          $('.fa-refresh').removeClass('fa-spin');
        },
        error: function error(data) {
          console.log(data); //  throw "Error in ajax form submission";
        }
      });
    },
    newFolder: function newFolder(event) {
      var dirPath = this.$data.currentDirectory;
      var folderName = $('[name="new_folder_name"]').val();
      $.post(event.target.action, {
        _token: filemanager.$data._csrfToken,
        dir_path: dirPath,
        new_folder_name: folderName
      }, function (data) {
        if (typeof data.success !== 'undefined') {
          console.log("Dir created: " + dirPath + '/' + folderName);
          $('#new_folder').modal('hide');
          $('[name="new_folder_name"]').val("");
          filemanager.$data.folders.push(folderName);
        } else {
          console.log("Error:");
          console.log(data);
        }
      });
    },
    upload: function upload(event) {
      console.log("Uploading ...");
      var dirPath = filemanager.$data.currentDirectory;
      var fileSelect = $('#input-2');
      var files = fileSelect[0].files;
      var formData = new FormData();
      formData.append('_token', filemanager.$data._csrfToken);
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
        success: function success(data) {
          if (typeof data.success !== 'undefined') {
            console.log(data);
            $('#upload_file_to_storage').modal('hide');
            fileSelect.val("");
            fileSelect.fileinput("clear");

            for (var i = 0; i < data.uploadedFileNames.length; i++) {
              console.log(filemanager.basename(data.uploadedFileNames[i]));
              filemanager.$data.files.push(filemanager.basename(data.uploadedFileNames[i]) + '.' + filemanager.getFileExtension(data.uploadedFileNames[i]));
            }
          } else {
            console.log("Error" + data);
          }
        },
        error: function error() {
          console.log("Error in ajax form submission");
        }
      });
    },
    basename: function basename(url) {
      return (url = /(([^\/\\\.#\? ]+)(\.\w+)*)([?#].+)?$/.exec(url)) != null ? url[2] : '';
    },
    deleteModal: function deleteModal(file) {
      var modal = $('#delete_sample');
      $($($(modal.find('div.modal-body')).find('div')).find('b')).html(function (event, html) {
        return filemanager.basename(file);
      });
      modal.find('a').data('file', file);
      modal.modal('toggle');
    },
    renameModal: function renameModal(file) {
      this.select(file);
      var modal = $('#rename_sample');
      $("#selected").val(file);
      modal.modal('toggle');
    },
    renameFile: function renameFile(event) {
      file = filemanager.$data.currentDirectory + '/' + $(event.target).data('old_name');
      console.log(file);
      $.post(event.target.action, {
        _token: filemanager.$data._csrfToken,
        old_file: filemanager.$data.currentDirectory + '/' + $('[name="old_name"]').val(),
        new_file: filemanager.$data.currentDirectory + '/' + $('[name="new_name"]').val()
      }, function (data) {
        if (typeof data.success !== 'undefined') {
          filemanager.open(filemanager.$data.currentDirectory);
          $('#rename_sample').modal('hide');
        } else {
          console.log(data);
        }
      });
    },
    deleteFile: function deleteFile(event) {
      file = filemanager.$data.currentDirectory + '/' + $(event.target).data('file');
      $.get('admin/file-manager/delete', {
        _token: filemanager.$data._csrfToken,
        file: file
      }, function (data) {
        if (typeof data.success !== 'undefined') {
          var index = filemanager.$data.files.indexOf($(event.target).data('file'));

          if (index > -1) {
            filemanager.$data.files.splice(index, 1);
          }

          index = filemanager.$data.folders.indexOf($(event.target).data('file'));

          if (index > -1) {
            filemanager.$data.folders.splice(index, 1);
          }

          $('#delete_sample').modal('hide');
        } else {
          console.log(data);
        }
      });
    },
    getUrlVar: function getUrlVar(location, vary) {
      var vars = [],
          hash;
      var hashes = location.slice(location.indexOf('?') + 1).split('&');

      for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
      }

      return vars[vary];
    },
    getUrlParam: function getUrlParam(paramName) {
      var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
      var match = window.location.search.match(reParam);
      return match && match.length > 1 ? match[1] : null;
    },
    returnFileUrl: function returnFileUrl(filepath) {
      // Simulate user action of selecting a file to be returned to CKEditor.
      var funcNum = 1;
      /*getUrlParam( 'CKEditorFuncNum' );*/

      var fileUrl = filepath;
      window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
      window.close();
    },
    getFileExtension: function getFileExtension(fileName) {
      return fileName.substr(fileName.lastIndexOf('.') + 1);
    },
    isKnownExtension: function isKnownExtension(fileName) {
      return $.inArray(this.getFileExtension(fileName).toLowerCase(), this.$data.knownFileExtensions) >= 0;
    }
  }
});

/***/ }),

/***/ 2:
/*!**************************************************!*\
  !*** multi ./resources/assets/js/filemanager.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/linux/workspace/HorizontCMS/resources/assets/js/filemanager.js */"./resources/assets/js/filemanager.js");


/***/ })

/******/ });