/////////////////////Lock screeen/////////////

if(sessionStorage.getItem("lock")=="1"){
		lock_screen();
}







function lock_screen(){
          console.log('Screen is locked');
          $('#lock_screen').modal({keyboard: false, backdrop: 'static'});
          $('#lock_screen').modal('show');

          $("#lock_pwd1").keyup(function(event){
            if(event.keyCode == 13){
                $("#unlock_button").click();
    		}
});

   	sessionStorage.setItem("lock",1);

}





function lock_up_screen(){

  $.post("admin/user/ajaxAuthenticate",{
          pwd: $('#lock_pwd1').val(),
        },
        function(data,status){

            console.log("Ajax request status: " + status);

            if(data=="TRUE"){

              $('#lock_screen').modal('hide');
              console.log('Screen unlocked');

              $('#lock_pwd1').val('');
              sessionStorage.setItem("lock",0);

            }
            else{
              console.log("Wrong password!");
                $('#lock_pwd1').parent('div').addClass('has-error');
             // $('#lock_pwd1').css('border-color','red');
            }


      });


}






setTimeout( lock_screen ,1000*60*5);

