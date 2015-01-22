$(document).ready(function() {
	$("#submit").click(function() {
		var auto_ajax = "div:id:wrapper";
		var email = $("#email").val();
		$.post("", {auto_ajax:auto_ajax,email:email},
			function(data) {
				$("#wrapper").fadeOut("fast", function(){
							$("#wrapper").replaceWith(data[0].content);
							$("#wrapper").fadeIn("fast");
				});
				
		},'json');
	});
});