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
	<link rel="stylesheet" href="style.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
	</script>
	<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js">
	</script>
	</head> 
	<body> 
		<div data-role="header" data-position="inline" data-theme="b">
			<h1>Einkauf</h1>
			<a href="add_shopping.html" data-icon="add" iconpos="notext" data-position="inline" data-rel="dialog">neuer Artikel</a>
		</div><p>
		<div class="content-primary" style="margin:3px;">	
			<ul data-role="listview" data-inset="true" data-split-icon="minus" data-split-theme="d" id="shopping_list">
			</ul>
		</div>	
		<div data-role="footer" data-position="inline" data-theme="b">
			<a href="kalender.php" class="link" data-role="button" data-icon="calendar" data-iconpos="notext">Kalender</a>
			<a href="index.php" class="link" data-role="button" data-icon="check" data-iconpos="notext">TODO</a>
			<a href="einkauf.php" class="link" data-role="button" data-icon="shop" data-iconpos="notext">Einkauf</a>
		</div>
	</body>
</html>

<script language="javascript">
var list_id = 'shopping_list_1';
$("document").ready(function() {
    onBodyLoad();
});
function onBodyLoad(){
	alert('h')
	var todo = "";
	setTimeout(function() { window.scrollTo(0, 1) }, 100);
	get_list();
	
	$("#remove").live("click",function(e){
		var index = $(this).closest("li").attr("id");
		$(this).closest("li").slideUp(function(){
		
			// clear existing list UI
			$("#shopping_list").html("");

			$.ajax({
	            type: 'POST',
	            url: 'ajax.php?do=delete_entry&list_id=' + list_id + '&entry=' + index + '&token=HgjHGKJHjHJKhKhKHKh',
	            contentType: "application/json; charset=utf-8",
	            success: function(){get_list();}
	        });
			
		});
	});
}
function save_shopping(){
	var artikel = $("#textinput1").val();

	if(artikel.length){
		// store item in file via ajax
		$.ajax({
            type: 'POST',
            url: 'ajax.php?do=save_shopping_entry&list_id=' + list_id + '&entry=' + artikel + '&token=HgjHGKJHjHJKhKhKHKh',
            contentType: "application/json; charset=utf-8",
            success: function(){
            	$("#shopping_list").html("");
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
			$("#shopping_list").append('<li id="'+a+'"><a href="#">'+data_obj[a].entry+'</a><a href="#" data-rel="dialog" data-transition="slideup" id="remove">Remove</a></li>');
		}
		
		// Refresh list so jquery mobile can apply iphone look to the list
		$("#shopping_list").listview();
		$("#shopping_list").listview("refresh");
	}
}
</script>