$(window).keydown(
	function(event){

		if(event.ctrlKey && event.which == 83){
            event.preventDefault();
            $('#submit-btn').trigger('click'); 
            return false;
        };
    }
);