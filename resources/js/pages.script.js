/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/assets/js/pages.script.ts ***!
  \*********************************************/


$(document).ready(function () {
  var submenus = $('#submenus');
  submenus.hide();
  $('#level').change(function () {
    $(this).find('option:selected').val() == '1' ? submenus.show() : submenus.hide();
  });
  /*
    $('#upload-bar').hide();
    $('#select-bar').hide();
    $('#back-button').hide();
  
    $('#upload_select').click(
        function(){
  
          $('#img-dashboard').hide();
          $('#upload-bar').show();
        $('#back-button').show();
        }
  
      );
  
  
     $('#select_select').click(
        function(){
  
          $('#img-dashboard').hide();
          $('#select-bar').show();
          $('#back-button').show();
  
        }
  
      );
  
  
     $('#back-button').click(
        function(){
            $('#upload-bar').hide();
          $('#select-bar').hide();
          $('#back-button').hide();
          $('#img-dashboard').show();
  
  
        }
      );
  */

  $("#selected-image").hide();
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      var _a;

      $('#preview-i').attr('src', ((_a = e === null || e === void 0 ? void 0 : e.target) === null || _a === void 0 ? void 0 : _a.result) || null);
      $("#select-photo").hide();
      $("#selected-image").show();
    };

    reader.readAsDataURL(input.files[0]);
  }
}
/*  $("#input-2").change(() => {
      readURL($(this));
  }); */


function ajaxGetSlug() {
  var text = $('#menu-title').val();

  if (text != "") {
    $.get("api/get-page-slug/" + text, function (data) {
      $("#ajaxSlug").html("/" + data);
    });
  } else {
    $("#ajaxSlug").html("");
  }
}
/******/ })()
;