
'use strict';

/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

import * as $ from 'jquery';
import 'jquery-ui-bundle';

function dragndrop() {
	//Helper function to keep table row from collapsing when being sorted
	var fixHelperModified = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index)
		{
		  $(this).width($originals.eq(index).width())
		});
		return $helper;
	};

	function after_drop(){

		var alist = [];

		$("#page-list-table tbody tr").each(function(iter) {
		  var $this = $(this);
		  var pageId = $this.find('td').eq(1).html().split(" ")[0];

		  alist[iter] = pageId;

		});

		$.post("admin/page/reorder",
	    {
	    	_token: $("#orderer").data("csrf"),
	        order: JSON.stringify(alist)
	    },
	    function(data, status){
	        console.log("Data: " + data + "\nStatus: " + status);
	    });



	}


	//Make diagnosis table sortable
	$("#page-list-table tbody").sortable({
    	helper: fixHelperModified,
		stop: function(event,ui) {renumber_table('#page-list-table'); after_drop();}
	}).disableSelection();


	//Delete button in table rows
	$('table').on('click','.btn-delete',function() {
		var tableID = '#' + $(this).closest('table').attr('id');
		var r = confirm('Delete this item?');
		if(r) {
			$(this).closest('tr').remove();
			renumber_table(tableID);
			}
	});

};

//Renumber table rows
function renumber_table(tableID) {
	$(tableID + " tr").each(function() {
		var count = $(this).parent().children().index($(this)) + 1;
		$(this).find('.priority').html(count);
	});
}




export default function dragndroporder(){


	$('#orderer').toggleClass('btn-default');
	$('#orderer').toggleClass('btn-success');


	if($('#page-list-table').hasClass('order-active')){

		$('.torder').remove();

		$('#page-list-table').removeClass('order-active');

	} else {


		$('table').find('tr').each(function(){
			$(this).find('th').eq(0).before("<th class='col-md-1 torder'>Reorder</th>");
			$(this).find('td').eq(0).before("<td class='torder'><i class='well well-sm fa fa-arrows-v' style='border-radius:3px;cursor:grab;font-size:20px;' aria-hidden='true'></i></td>");
		});


		$('#page-list-table').addClass('order-active');


		dragndrop();

	}
	
}

window.dragndroporder = dragndroporder;