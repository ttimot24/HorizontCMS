var path = window.location.pathname;
var path = path.substring(0, path.lastIndexOf('/')) +"/";





function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}





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

  url = url.split("/");

  if(url[1]==""){
    $('#whatsup').html("<b>&nbsp&nbsp&nbspWelcome, I am alive!</b></br>");

             setTimeout(function() {
          $('#whatsup').fadeOut('fast');
           }, 5000);
    
  }
  