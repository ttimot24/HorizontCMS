 $(document).ready(function() {

  var submenus = $('#submenus');

  submenus.hide();

   $('#level').change(function() {
      $(this).find('option:selected').val() == '1' ? submenus.show() : submenus.hide();
   });


    $("#selected-image").hide();

});



   function readURL(input: HTMLInputElement) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#preview-i').attr('src', (e?.target?.result as string) || null);
                $("#select-photo").hide();
                $("#selected-image").show();
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }


  function ajaxGetSlug(){

    let text = $('#menu-title').val();

    if(text!=""){
      $.get("api/get-page-slug/"+text, function( data ) {

        $("#ajaxSlug").html( "/"+data );
      });
    }else{
      $("#ajaxSlug").html("");
    }


  }
