<?php

?>
<html> 
	<head>
	<title>TODO App</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
	</script>
	<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js">
	</script>
	</head> 
	<body onload="onBodyLoad()"> 
		<div data-role="header" data-position="inline" data-theme="b">
			<!--<a href="#" data-theme="c" data-icon="delete" iconpos="notext" data-position="inline" data-rel="dialog" id="clear">Clear</a>-->
			<h1>TODO</h1>
			<a href="add_todo.html" data-icon="add" iconpos="notext" data-position="inline" data-rel="dialog">neue Aufgabe</a>
		</div><p>
		<div class="content-primary" style="margin:3px;">	
			<ul data-role="listview" data-inset="true" data-split-icon="minus" data-split-theme="d" id="todo_list">
			</ul>
		</div>	
		
	</body>
</html>

<script language="javascript">
var i = localStorage.length;
var list_id = 'list_1';

function onBodyLoad(){
	var todo = "";
	
	// create_new_list();
	get_list();
	
	// $("#clear").click(function(){
	// 	localStorage.clear();
	// 	$("#todo_list li").fadeOut(function(){
	// 		$(this).html("");
	// 	});
	// });

	$("#remove").live("click",function(e){
		var index = $(this).closest("li").attr("id");
		$(this).closest("li").slideUp(function(){
		
			// remove the selected item
			//localStorage.removeItem('names_'+index);
			
			// rearrange localstorage array 
			// for(i=0; i<localStorage.length; i++) {
			//   if( !localStorage.getItem("names_"+i)) {
			// 	localStorage.setItem("names_"+i, localStorage.getItem('names_' + (i+1) ) );
			// 	localStorage.removeItem('names_'+ (i+1) );
			//   }
			// }

			
			// clear existing list UI
			$("#todo_list").html("");

			$.ajax({
	            type: 'POST',
	            url: 'ajax.php?do=delete_entry&list_id=' + list_id + '&entry=' + index + '&token=HgjHGKJHjHJKhKhKHKh',
	            contentType: "application/json; charset=utf-8",
	            data: '',
	            timeout: 500,
	            success: 'get_list'
	        });
			
		});
	});
}
// function create_new_list(){
// 	for (var i = 0; i < localStorage.length; i++){
// 		todo = localStorage.getItem('names_'+i);
// 		$("#todo_list").append('<li id="'+i+'"><a href="#">'+todo+'</a><a href="#" data-rel="dialog" data-transition="slideup" id="remove">Remove</a></li>');
// 	}	
// 	// Refresh list so jquery mobile can apply iphone look to the list
// 	$("#todo_list").listview();
// 	$("#todo_list").listview("refresh");
// }
function save_todo(){
	var todo = $("#textinput1").val();
	if(todo.length){
		// store item in local storage
		//localStorage['names_'+i] = todo;
		
		// store item in file via ajax
		$.ajax({
            type: 'POST',
            url: 'ajax.php?do=save_entry&list_id=' + list_id + '&entry=' + todo + '&token=HgjHGKJHjHJKhKhKHKh',
            contentType: "application/json; charset=utf-8",
            data: '',
            timeout: 500,
            success: 'get_list'
        });
	}
}
function get_list() {
	$.ajax({
        type: 'POST',
        url: 'ajax.php?do=get_list&list_id=' + list_id + '&token=HgjHGKJHjHJKhKhKHKh',
        contentType: "application/json; charset=utf-8",
        timeout: 500,
        success: function(data) {refresh_list(data);}
    });
}
function refresh_list($data) {
	var data_obj = JSON.parse(data);
	for (var a=0; a<data_obj.length; a++) {
		$("#todo_list").append('<li id="'+a+'"><a href="#">'+data_obj[a]+'</a><a href="#" data-rel="dialog" data-transition="slideup" id="remove">Remove</a></li>');
	}
	
	// Refresh list so jquery mobile can apply iphone look to the list
	$("#todo_list").listview();
	$("#todo_list").listview("refresh");	
	i++;
}
</script>