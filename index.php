<?php

?>
<html> 
	<head>
	<title>TODO App</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="apple-touch-icon" href="icon.png">
	<link rel="apple-touch-startup-image" href="icon.png">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
	</script>
	<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js">
	</script>
	<style type="text/css">
		.hoch {
			background-image: linear-gradient(#fff,#F55);
		}
		.mittel {
			background-image: linear-gradient(#fff,#FF0);
		}
		.niedrig {
			background-image: linear-gradient(#fff,#5F5);
		}
		[data-role=footer]{bottom:0; position:absolute !important; top: auto !important; width:100%;}  
		
	</style>
	</head> 
	<body onload="onBodyLoad()"> 
		<div data-role="header" data-position="inline" data-theme="b">
			<h1>TODO</h1>
			<a href="add_todo.html" data-icon="add" iconpos="notext" data-position="inline" data-rel="dialog">neue Aufgabe</a>
		</div><p>
		<div class="content-primary" style="margin:3px;">	
			<ul data-role="listview" data-inset="true" data-split-icon="minus" data-split-theme="d" id="todo_list">
			</ul>
		</div>	
		<div data-role="footer" data-position="inline" data-theme="b">
			<a href="kalender.php" style="margin-bottom:15px; margin-left:15px;" data-role="button" data-icon="calendar" data-iconpos="notext">Kalender</a>
			<a href="index.php" style="margin-bottom:15px; margin-left:15px;" data-role="button" data-icon="check" data-iconpos="notext">TODO</a>
			<a href="einkauf.php" style="margin-bottom:15px; margin-left:15px;" data-role="button" data-icon="star" data-iconpos="notext">Einkauf</a>
		</div>
	</body>
</html>

<script language="javascript">
var list_id = 'list_1';

function onBodyLoad(){
	var todo = "";
	setTimeout(function() { window.scrollTo(0, 1) }, 100);
	get_list();
	
	$("#remove").live("click",function(e){
		var index = $(this).closest("li").attr("id");
		$(this).closest("li").slideUp(function(){
		
			// clear existing list UI
			$("#todo_list").html("");

			$.ajax({
	            type: 'POST',
	            url: 'ajax.php?do=delete_entry&list_id=' + list_id + '&entry=' + index + '&token=HgjHGKJHjHJKhKhKHKh',
	            contentType: "application/json; charset=utf-8",
	            success: function(){get_list();}
	        });
			
		});
	});
}
function save_todo(){
	var todo = $("#textinput1").val();
	var prio = $("#prioselect").val();

	if(todo.length){
		// store item in file via ajax
		$.ajax({
            type: 'POST',
            url: 'ajax.php?do=save_entry&list_id=' + list_id + '&entry=' + todo + '&prio=' +prio+ '&token=HgjHGKJHjHJKhKhKHKh',
            contentType: "application/json; charset=utf-8",
            success: function(){
            	$("#todo_list").html("");
            	get_list();
            }
        });
	}
}
function get_list() {
	$.ajax({
        type: 'POST',
        url: 'ajax.php?do=get_list&list_id=' + list_id + '&token=HgjHGKJHjHJKhKhKHKh',
        contentType: "application/json; charset=utf-8",
        success: function(data) {refresh_list(data);}
    });
}
function refresh_list(data) {
	if (data!=null && typeof data!='undefined' && data!='') {
		var data_obj = JSON.parse(data);
		for (var a=0; a<data_obj.length; a++) {
			$("#todo_list").append('<li id="'+a+'" class="'+data_obj[a].prio+'"><a href="#">'+data_obj[a].entry+'</a><a href="#" data-rel="dialog" data-transition="slideup" id="remove">Remove</a></li>');
		}
		
		// Refresh list so jquery mobile can apply iphone look to the list
		$("#todo_list").listview();
		$("#todo_list").listview("refresh");
	}
}
</script>