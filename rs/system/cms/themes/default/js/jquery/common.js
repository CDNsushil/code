/**
 *--------------------------------------------------------------------------------------- 
 * This is common file for all section 
 * author: Rajendra patidar
 *---------------------------------------------------------------------------------------
 */
 /*
 *--------------------------------------------------------------------------------------- 
 * This is common variable 
 *---------------------------------------------------------------------------------------
 */
 var base_url = window.location.origin;
 var formError=false;
 /*
 *--------------------------------------------------------------------------------------- 
 * This function is used to not allowed user of key bord and cut copy past option
 *---------------------------------------------------------------------------------------
 * @parm1 = @void
 */ 
	 
	 $(document).ready(function(){
		 $(".readonly").keypress(function(e) {
			 return false;
		 });
		   $('.readonly').bind("cut copy paste",function(e) {
			e.preventDefault();
		});
	});
/*
 *--------------------------------------------------------------------------------------- 
 * This function is used to  slide up
 *---------------------------------------------------------------------------------------
 */
 
function slideUp(checkClass){
	jQuery(checkClass).slideUp('slow');
}

/*
 *--------------------------------------------------------------------------------------- 
 * This function is used to  slide down
 *---------------------------------------------------------------------------------------
 */
function slideDown(checkClass){
		jQuery(checkClass).slideDown('slow');
}


$( document).ready(function() {
	
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to accept only alphanumeric value
	 *---------------------------------------------------------------------------------------
	 */ 
	
	$(".alpha_num").keypress(function(e) {
		  
			if(((e.which>=34 && e.which<=47) || (e.which>=58 && e.which<=64) || (e.which>=91 && e.which<=96) || (e.which>=123 && e.which<=126)) && e.which!=45)
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('Please enter alpha/numeric charactor only.');
				return false;
			}	
			$(this).next('span').fadeOut(2000);
		});	
	$(".alpha_num").blur(function(e) {
		if(((e.which>=34 && e.which<=47) || (e.which>=58 && e.which<=64) || (e.which>=91 && e.which<=96) || (e.which>=123 && e.which<=126)) && e.which!=45)
		{
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter alpha/numeric charactor only.');
			return false;
		}	
		$(this).next('span').fadeOut(2000);
	});	
	
	 
    /*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to allowed only numeric value
	 *---------------------------------------------------------------------------------------
	 * @parm1 = @void
	 */ 
	 
	 $(document).ready(function(){
	 $(".numeric").keypress(function(e) {
		 
		 
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)))
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('Please enter numeric value only.');
				return false;
			}	
			$(this).next('span').fadeOut(2000);
		});
		 
    }); 
			
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to accept only alpha charactor value
	 *---------------------------------------------------------------------------------------
	 */ 

	$(".alpha").keypress(function(e) {
			if(!((e.which>=65 && e.which<=90) || (e.which>=97 && e.which<=122) || e.which==8 || e.which==0 ||  e.which==45 || e.which<34))
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('Please enter letters  only.');
				return false;
			}	
		});	
	$(".alpha").blur(function(e) {
			if(!((e.which>=65 && e.which<=90) || (e.which>=97 && e.which<=122) || e.which==8 || e.which==0 ||  e.which==45 || e.which<34))
			{
				$(this).next('span').html('Please enter letters  only.');
				return false;
			}	
			$(this).next('span').fadeOut(2000);
		});	
				
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to check email address formate
	 *---------------------------------------------------------------------------------------
	 */ 
	 $('.email').blur(function(){
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		var data=pattern.test($(this).val());
	
		if(!data){
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid email.');
			return false;
		}
		$(this).next('span').fadeOut(2000);
		return true;
	});	
	
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to check email address formate
	 *--------------------------------------------------------------------------------------
	 */
	 $('.valid_url').blur(function(){
		 
		 var validUrl=new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
		 var pattern=validUrl.test($(this).val());
		if(!pattern){
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid url.');
		}else{
			$(this).next('span').fadeOut(2000);
			formError=false;
			return true;
		}
		formError=true;
		return false;
	});

	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to change captcha code
	 *---------------------------------------------------------------------------------------
	 */ 
	 
	$('.change_captcha').click(function(){
			$.ajax({
			  type: "POST",
			  url: base_url+'users/getCapchaCode',
			  data: '',
				success: function(data) {
					$('#cap_image').html(data);
				}
			});
	});

	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to change feature
	 *---------------------------------------------------------------------------------------
	 */ 
	
	$('.select_feature').change(function(){
	
		var id=$(this).val();

		var option=$(".select_feature option[value="+id+"]").text();
		$('.feature_head').html(option);
			 //$(".paypal_img").attr("href",base_url+"membership/paypalPayment/"+id);
			$.ajax({
			  type: "POST",
			  url: base_url+'membership/getSelectMembership',
			  data: 'id='+id,
				success: function(data) {
				
					$('.feature_data').html(data);
					if(data==''){
						$('.feature_wrapper').hide();
						return true;
					}
					$('.feature_wrapper').show();
				}
			});
	});
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to  check pass & confirm pass
	 *---------------------------------------------------------------------------------------
	 */
		$(".pass").blur(function(){
			var pass=$('#user_password').val();
			var con=$('#confirm_password').val();
			if(pass!='' && pass.length<8){
				$(this).next('span').fadeIn('fast');
				$('#user_password').next('span').html("Password length at least eight.");
				return false;
			}
			$('#user_password').next('span').fadeOut(2000);
			if(con!='' && pass!=con){
				$(this).next('span').fadeIn('fast');
				jQuery('.pass_error').show();
				$(this).next('span').html("Password does not match!");
				return false;
			}
			if(pass==con && pass.length>=8){
				$('.pass').next('span').fadeOut(2000);
			}
		});
		
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to  check pass & confirm pass when click on submit button
	 *---------------------------------------------------------------------------------------
	 */
	$('.checkPass').click(function(){
		
			var pass=$('#user_password').val();
			var con=$('#confirm_password').val();
			if(pass!='' && pass!=con){
		
				$('#confirm_password').next('span').fadeIn('fast');
				$('#confirm_password').next('span').html("Password does not match!");
				return false;
			}else{
				$('.pass').next('span').fadeOut(2000);
			}
		});
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to  delete confirmation
	 *---------------------------------------------------------------------------------------
	 */
	jQuery(document).delegate('.deleteConfirm','click',function(){
		var val=confirm('Are you sure you want to delete?');
		if(val){
			return true;
		}
		return false;
	});
	
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to  check form error
	 *---------------------------------------------------------------------------------------
	 */
	 jQuery('form').submit(function(){
		 if(formError==true){
			 return false;
		 }
		 return true;
	 });
	 /*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to  check atleast one option from in  multiple options
	 *---------------------------------------------------------------------------------------
	 */
	 jQuery(document).delegate('.selectMul','click',function(){
		var check=false;
		jQuery('.check_option').each(function() {
		   if (jQuery(this).is(":checked")) {
				check=true;
				return false;
		   }
		});
		if(check){
			return true;
		}
		alert('Please select at least on option.');
		return false;
	});
	
});
