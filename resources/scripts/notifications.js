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

               //  alert('HorizontCMS: Woops! We lost the connection with the server! Trying to reconnect...');
               //  console.log('HorizontCMS: Woops! We lost the connection with the server! Trying to reconnect...');
                 // $('<div class="modal-backdrop"><h1>Woops! We lost the connection with the server!</h1></div>').appendTo(document.body);

            }
        });

			}





, 3000);