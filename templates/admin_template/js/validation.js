$(function () {
	/**
	* Function to validate admin login
	*/
	$('.loginbtn').click(function(){
		flag = 0;
		var username =  $('#username').val();
		var password =  $('#password').val();

		if(jQuery.trim(username) == "" ){
			$('#validation_username').fadeIn('slow');
			$('#username').css('border','2px solid red');
			flag++;
		}
		else{
			$('#validation_username').fadeOut('slow');
			$('#username').css('border','none');
		}

		if(jQuery.trim(password) == ""){
			$('#validation_password').fadeIn('slow');
			$('#password').css('border','2px solid red');
			flag++;
		}
		else{
			$('#validation_password').fadeOut('slow');
			$('#password').css('border','none');
		}
		
		if(flag > 0){
			$("#err_msg").css('display','none');
			return false;
		}
		return true;
	});

	/**
	* Function to validate edit page by admin
	*/
	$('#edit_page').click(function(){
		flag = 0;
		page_title = $('#page_title').val();
		if(jQuery.trim(page_title)==""){
			$('#validation_page_title').fadeIn('slow');
			flag++;
		}else{
			$('#validation_page_title').fadeOut('slow');
		}
		
		if(flag > 0){
			return false;
		}
		return true;
	});

	/**
	* Function to hide flash message
	*/
	$(".closestatus").click(function(){
		$(".status").fadeOut("slow");
	});

});