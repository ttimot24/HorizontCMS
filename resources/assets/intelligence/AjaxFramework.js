/**
* AjaxFramework
* @author: Timot Tarjani
* @date: 2016
*
**/

function ajaxCall(method,url,script){

    try{
          if(!window.jQuery){
            throw "jQuery is not installed!";
          }

       $.ajax({
            type: method,
            url: url,
           /* data:x,*/
            success: function(data){
                eval(script);
            }
        });

    }
    catch(error){
        document.write('<b>JavaScript: </b>' +error +" | on line: " +error.lineNumber);
    }




 }