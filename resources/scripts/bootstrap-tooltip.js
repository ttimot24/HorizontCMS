

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
  

