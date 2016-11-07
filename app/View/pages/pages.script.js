 $(document).ready(function() {
  $('#submenus').hide();


   $('#level').change(function() {
      if($(this).find('option:selected').val() == '0') {
         $('#submenus').show();

      }
      else{

        $('#submenus').hide();
      }
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
                $('#preview-i').attr('src', e.target.result);
                $("#select-photo").hide();
                $("#selected-image").show();
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }


    $("#input-2").change(function(){
        readURL(this);
    });






  /*function ajaxGetSlug(){

    text = $('#menu-title').val();

    if(text!=""){
      $.get("admin/ajax/ajaxConvertSlug/"+text, function( data ) {
        $("#ajaxSlug").html( "/"+data );
      });
    }else{
      $("#ajaxSlug").html("");
    }


  }*/
