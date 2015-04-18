// JavaScript Document
$('document').ready(function(){
	
	
		// code for collapsible start
	$('#security_icon').click(function() {
		if($("#security_display").css("display") == "block")
		{
			//$("#edit_img").attr('src',BASEPATH+'templates/default/images/plus.png');
		}
		else
		{
			//$("#edit_img").attr('src','');
		}
		$('#security_display').slideToggle('fast');
	});


	// code for collapsible start
	$('#secure_button').click(function() {
		if($("#secure_div").css("display") == "block")
		{
			//$("#edit_img").attr('src',BASEPATH+'templates/default/images/plus.png');
		}
		else
		{
			//$("#edit_img").attr('src','');
		}
		$('#secure_div').slideToggle('fast');
	});


	// code for collapsible start
	$('#loign_not_button').click(function() {
		if($("#login_not_div").css("display") == "block")
		{
			//$("#edit_img").attr('src',BASEPATH+'templates/default/images/plus.png');
		}
		else
		{
			//$("#edit_img").attr('src','');
		}
		$('#login_not_div').slideToggle('fast');
	});

	// code for collapsible start
	$('#loign_app_button').click(function() {
		if($("#login_app_div").css("display") == "block")
		{
			//$("#edit_img").attr('src',BASEPATH+'templates/default/images/plus.png');
		}
		else
		{
			//$("#edit_img").attr('src','');
		}
		$('#login_app_div').slideToggle('fast');
	});

	// code for collapsible start
	$('#app_button').click(function() {
		if($("#app_div").css("display") == "block")
		{
			//$("#edit_img").attr('src',BASEPATH+'templates/default/images/plus.png');
		}
		else
		{
			//$("#edit_img").attr('src','');
		}
		$('#app_div').slideToggle('fast');
	});

	// code for collapsible start
	$('#recognized_button').click(function() {
		if($("#recognized_div").css("display") == "block")
		{
			//$("#edit_img").attr('src',BASEPATH+'templates/default/images/plus.png');
		}
		else
		{
			//$("#edit_img").attr('src','');
		}
		$('#recognized_div').slideToggle('fast');
	});

	// code for collapsible start
	$('#active_button').click(function() {
		if($("#active_div").css("display") == "block") { 
		} else { }
		$('#active_div').slideToggle('fast');
	});

	/****************************************/
	      

	
$('.menu ul li:last-child').addClass('last');
$('.menu ul li:first-child').addClass('first');

});
	
/**
* Function for delete message
**/	
function confirm_delete_message(msg_id){
		$.ajax({
			url:BASEPATH+"message/message_delete_confirm",
			dataType:"json",
			type:"post",
			data:{
				msg_id		:msg_id			
			},
			success:function(con_data){
				$.fancybox(
					con_data.tpl,
					{
						'autoDimensions'	: false,
						'width'				:400,
						'height'			:110,
						'showCloseButton'	:true
					}
				);
			}
		});
}



/**
* Function for delete message
**/	
function delete_message(msgId){	
		$.ajax({
					url:BASEPATH+"message/deleteMessage",
					data:{
						msgId:msgId
					},
					type:"post",					
					success:function(data){
						if(data){
							$("#message_"+msgId).fadeOut();
						}
					}
				});
}




function is_incentive(flag)
{
	if(flag == 1)
	{
			$.ajax({
			url:BASEPATH+'profile/update_is_incentive',
			dataType:"json",
			success:function(data){
				//$('#upload_form').html(data.tpl);
				$.fancybox(
					data.tpl,
					{
						'autoDimensions'	: false,
						'width'				: 350,
						'height'			: 100
					}
				);
			}
		});
	}
	else
	{
		triggerClose();
	}
}


function update_notification_status(user_id)
{
	$('#show_notification').slideToggle('fast');
	$.post(BASEPATH+"user_notification/update_notification_status");
}


 //---  Function for search filter ---
 function search_filter(val)
 {
	    document.forms["filter_form"].submit();		
 }

 // Function for search by name or id
 function search_name(val)
 {
	    document.forms["search_form"].submit();
 }



//----------- Function for change user status ----------
function confirm_activation(activation_val,user_id){

		$.ajax({
			url:BASEPATH+"admin_users/activation_status",
			dataType:"html",
			type:"post",
			data:{
activation_val		:activation_val,																		user_id		:user_id			
			},
			success:function(con_data){
				$.fancybox(
					con_data,
					{
						'autoDimensions'	: false,
						'width'			:400,
						'height'		:210,
						'showCloseButton'	:true
					}
				);
			}
		});
}
/**
* Function to open message creator
**/
function create_new_message(){

	$("#loader").css('display','block');
	$.ajax({
		 url:BASEPATH+'message/createMessageUsers',
		//url:BASEPATH+'admin/admin/createMessageUsers',
		dataType:"html",
		success:function(data){
			
			$.fancybox(
				data,
				{
					'autoDimensions'	: false,
					'width'				:570,
					'height'			:250
				}
			);
			$("#loader").css('display','none');	
		}
	});
}

function create_message(user_type)
{

			$.ajax({
			url:BASEPATH+"admin_mail/create_message",
			dataType:"html",
			type:"post",
			data:{
			user_type	:user_type			
			},
			success:function(con_data){
				$.fancybox(
					con_data,
					{
						'autoDimensions'	: false,
						'width'			:400,
						'height'		:190,
						'showCloseButton'	:true
					}
				);
			}
		});
}

function send_msg_type(msg_type)
{
	if(msg_type=="all")
	{
		$("#send_id").css("display","block");
		$("#send_id").html("<input type='submit' name='send_all' id='send_all' value='Send'>");
	} else {
		$("#send_id").css("display","block");
		$("#send_id").html("<input type='submit' name='send_custom' id='send_custom' value='Continue'>");
	}
}

function check_all()
{
	if($("#chkall").is(':checked'))
	{
		$(".chk_user").attr('checked','checked');
	} else {
		$(".chk_user").removeAttr('checked');
	} 
}


// Function for user edit information
function valid_userdetail()
{
	var flag = true;
	var msg = "";
	if($("#name").val()=="") {
		$("#name").css("border-color","red");
		flag = false;
	}

	if($("#email").val()=="") {
		$("#email").css("border-color","red");
		flag = false;
	}

	if(flag==false) {
		return flag;	
	} else { 
		return true;	
	}
}


// Function for check mailing list checkbox
function valid_mailing()
{
	if($(".chk_user").is(':checked'))
	{ return true; } else { 
		var con_data = 'Please select checkbox';
				$.fancybox(
					con_data,
					{
						'autoDimensions'	: false,
						'width'			:200,
						'height'		:20,
						'showCloseButton'	:true
					}
				);


		return false;
	}
}


// Function for user statistics 
// Date : 15/05/2012
function user_stat()
{

		$.ajax({
			url:BASEPATH+"admin_statistics/user_statistics",
			dataType:"html",
			type:"post",
			success:function(con_data){
			$.fancybox(
					con_data,
					{
						'autoDimensions'	:true
					}
				);
			}
		});
}

function country_stat()
{
	$.ajax({
			url:BASEPATH+"admin_statistics/country_statistics",
			dataType:"html",
			type:"post",
			success:function(con_data){
			$.fancybox(
					con_data,
					{
						'autoDimensions'	:false,
						'width'			:550,
						'height'		:250,
						'showCloseButton'	:true
					}
				);
			}
		});
}

// Function for update activity
// Date : 15/05/2012
function update_activity_point(table_name,col_name,val,whr_col,whr_id)
{
		$.ajax({
			url:BASEPATH+"admin_point/update_point",
			dataType:"html",
			type:"post",
			data:{
			table_name 	:table_name,
			col_name	:col_name,
			val		:val,
			whr_col		:whr_col,
			whr_id		:whr_id
			},
			success:function(con_data){
			$.fancybox(
					con_data,
					{
						'autoDimensions'	:false,
						'width'			:550,
						'height'		:180,
						'showCloseButton'	:true
					}
				);
			}
		});
}

// Function for validate activity point
// Date : 15/05/2012
function check_val(){
	point  = $('#point').val();
		if(point=='') {
				$('#point').css("border-color", "red");
				$('#point_error').html('<font color="red">Please insert valid point</font>');
		} else if(isNaN(point)) { 	
				$('#point').css("border-color", "red");
				$('#point_error').html('<font color="red">Please insert valid point</font>');
		} else  {
			$("#update_point").submit();
		}
	}
	
	
	/**
	* Function for save sequre data 
	*/
	function saveSequre(field_name,check_id){
		var secure_val = 0;
			if($("#"+check_id).is(':checked')) {
			secure_val = 1;
			} 

			 $.ajax({
			url:BASEPATH+"profile/save_setting",
			dataType:"html",
			type:"post",
			data:{
			secure_val 	:secure_val,			
			field_name	:field_name
			},
			success:function(con_data){
			alert(con_data);
			/* $.fancybox(
					con_data,
					{
						'autoDimensions'	:false,
						'width'			:550,
						'height'		:250,
						'showCloseButton'	:true
					}
				); */
			}
		}); 
	}


	/**
	* Function for save sequre data 
	*/
	function saveSequrelogin(field_name,first_id,second_id){
		var first_val = 0;
		var second_val = 0;
		var secure_val = 0;

			if($("#"+first_id).is(':checked'))  {  first_val = 1;  } 
			if($("#"+second_id).is(':checked')) { second_val = 1; } 

			if(first_val==1 && second_val==0) {
			 secure_val = 1;
			}
			if(first_val==0 && second_val==1) {
			 secure_val = 2;
			}
			if(first_val==1 && second_val==1) {
			 secure_val = 3;
			}



			 $.ajax({
			url:BASEPATH+"profile/save_setting",
			dataType:"html",
			type:"post",
			data:{
			secure_val 	:secure_val,			
			field_name	:field_name
			},
			success:function(con_data){
			alert(con_data);
			/* $.fancybox(
					con_data,
					{
						'autoDimensions'	:false,
						'width'			:550,
						'height'		:250,
						'showCloseButton'	:true
					}
				); */
			}
		}); 
	}

	// Function for hide dive when user click on cancel link
	function saveCancel(div_id) {
		$('#'+div_id).slideToggle('fast');
	}	

	function generate_app_pass()
	{
		 $.ajax({
			url:BASEPATH+"profile/app_password",
			dataType:"html",
			type:"post",
			success:function(con_data){
			 $.fancybox(
					con_data,
					{
						'autoDimensions'	:false,
						'width'			:400,
						'height'		:100,
						'showCloseButton'	:true
					}
				); 
			}
		}); 
	}
	

	function app_password_validation()
	{
		alert('tt');
	}



