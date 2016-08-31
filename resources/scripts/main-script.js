window.onload = function(){

try{ if(!window.jQuery){ throw "jQuery is not installed!"; }

  console.log("Boot: root-path");

  var scripts = [
             //   'scripts/base.js',
                'resources/scripts/lock-screen.js',
                //'resources/scripts/bootstrap-tooltip.js',
              //  'resources/scripts/notifications.js'
                ];



  scripts.forEach(function(each){require_file(each);});


 console.log("Welcome, I am alive!");


















}
catch(error){
  document.write('<b>JavaScript: </b>' +error +" | on line: " +error.lineNumber);
}
};


function require_file(file){
  $.getScript(file)
    .done(function( script, textStatus ) {
        console.log("Script load successfull: "+file);
        eval(script);
    })
    .fail(function( jqxhr, settings, exception ) {
      console.log( "Script load error: " +file);
  });
}