var path = window.location.pathname;
path = path.substring(0, path.lastIndexOf('/')) +"/";





function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}





$(document).ready(function main(){

  $('a[rel=popover]').click(function(event){
    event.preventDefault();
}); 

  $('a[rel=popover]').popover({

  html: true,

  trigger: 'onclick',

  placement: 'bottom',

  content: function(){return '<img src="'+$(this).data('img') + '" style="width:150px;"/> '+ $(this).data('cont')+' ';}

});






  $('[data-toggle="tooltip"]').tooltip();

  var url = getParameterByName('url');

  console.log("Boot: " +path);
  console.log("Welcome, I am alive!");

  url = url.split("/");

  if(url[1]==""){
    $('#whatsup').html("<b>&nbsp&nbsp&nbspWelcome, I am alive!</b></br>");

             setTimeout(function() {
          $('#whatsup').fadeOut('fast');
           }, 5000);
    
  }
  else{
  	$('#whatsup').hide();
  }
  


});



		setInterval( 
		
 
      function(){ 

        $.ajax({
            url: "admin/ajax/ajaxGetNotices",
            type: 'GET',
            success: function(data,status){

                          if(data!=""){

                          $('#whatsup').fadeIn('fast');

                          $('#whatsup').html(data);


                          console.log("Loading data.." +data);

                          setTimeout(function() {
                              $('#whatsup').fadeOut('fast');
                           }, 5000);
                    
                        }

                    },
            error: function(data) {

                 alert('HorizontCMS: Woops! We lost the connection with the server! Trying to reconnect...');
                 console.log('HorizontCMS: Woops! We lost the connection with the server! Trying to reconnect...');
                 // $('<div class="modal-backdrop"><h1>Woops! We lost the connection with the server!</h1></div>').appendTo(document.body);

            }
        });

        /* $.get("admin/ajax/ajaxGetNotices",{

            },
            function(data,status){
              
                alert(status);

                  if(data!=""){

                  $('#whatsup').fadeIn('fast');

                  $('#whatsup').html(data);


                  console.log("Loading data.." +data);

                  setTimeout(function() {
                      $('#whatsup').fadeOut('fast');
                   }, 5000);
            
                }

            });*/

			}





, 3000);







/////////////////////Lock screeen/////////////
$( window ).load(function(){
	if(sessionStorage.getItem("lock")=="1"){
		lock_screen();
	}
}
);






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
              $('#lock_pwd1').css('border-color','red');
            }


      });


}






setTimeout( lock_screen ,1000*60*5);









