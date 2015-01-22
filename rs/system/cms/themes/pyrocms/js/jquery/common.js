/**
 *--------------------------------------------------------------------------------------- 
 * This is common file for all section 
 * author: Rajendra patidar
 *---------------------------------------------------------------------------------------
 */
	
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
				$(this).next('span').html('Please enter alpha/numeric charactor only.');
				return false;
			}	
			$(this).next('span').fadeOut(2000);
		});	
	$(".alpha_num").blur(function(e) {
		if(((e.which>=34 && e.which<=47) || (e.which>=58 && e.which<=64) || (e.which>=91 && e.which<=96) || (e.which>=123 && e.which<=126)) && e.which!=45)
		{
			$(this).next('span').html('Please enter letters  only.');
			return false;
		}	
		$(this).next('span').fadeOut(2000);
	});	
	
	 /*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to prevent copy  & paste
	 *---------------------------------------------------------------------------------------
	 */ 	
		
		 $('.copy_paste').bind("copy paste",function(e) {
			  e.preventDefault();
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
		
		var fieldName=$(this).attr('msg');
		
		if(fieldName==undefined){
			fieldName='characters';
		}
			if(!((e.which>=65 && e.which<=90) || (e.which>=97 && e.which<=122) || e.which==8 || e.which==0 ||  e.which==45 || e.which<34))
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('please enter '+fieldName+' only.');
				formError=true;
				return false;
			}	
		});	
		
		$(".alpha").blur(function(e) {
			if(!((e.which>=65 && e.which<=90) || (e.which>=97 && e.which<=122) || e.which==8 || e.which==0 ||  e.which==45 || e.which<34))
			{
				$(this).next('span').html('please enter '+fieldName+' only.');
				formError=true;
				return false;
			}	
			$(this).next('span').fadeOut(2000);
			formError=false;
		});	
				
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to check email address formate
	 *---------------------------------------------------------------------------------------
	 */ 
	 $('.email').blur(function(){
	
		var txt = $(this).val();
		var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
		if (!re.test(txt)) {
			
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid email.');
			formError=true;
			return false;
		}
		$(this).next('span').fadeOut(2000);
		formError=false;
		return true;
	});	
	
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to check email address formate
	 *--------------------------------------------------------------------------------------
	 */
	  $('.valid_url').blur(function(){
		 
		 var value = $(this).val();
		 
		 if(value==''){
			$(this).next('span').fadeOut(2000);
			formError=false;
			return true;
		} 	 
		 if(value.substr(0,4) != 'http'){
			value = 'http://' + value;
		 }
		 var validUrl = /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
		var pattern=validUrl.test(value);
		if(!pattern){
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid url.');
			formError=true;
		}else{
			$(this).next('span').fadeOut(2000);
			formError=false;
			return true;
		}
		return false;
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
			 $(".paypal_img").attr("href",BASE_URL+"membership/paypalPayment/"+id);
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
		 
	 $(".pass").blur(function(e) {
	
			if($(this).val()==''){
				$('.pass').next('span').fadeOut(2000);
				formError=false;
				return true;
			} 
			var str3=$('#user_password').val();
		    var str1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			var str2 = "0123456789";
	
			var i=0;
			var error1=true;
			var error2=true;
			var msg='Password should be contain a capital letter and a number.';
	
			for(i=1; i<=str3.length; i++){
				var res = str3.substring(i-1,i);
				if(str1.indexOf(res)>-1){
				
					error1=false;
					msg='Password should be contain a number.';
				}
			}
			
				for(i=1; i<=str3.length; i++){
					var res = str3.substring(i-1,i);
					if(str2.indexOf(res)>-1){
						
						error2=false;
						msg='Password should be contain a capital letter.';
					}
				}
		
			if(error1==true || error2==true){
			
				$('#user_password').next('span').fadeIn('fast');
				$('#user_password').next('span').html('<span class="cap_num">'+msg+'</span>');
				formError=true;
				return false;
				
			}else{
				$('.cap_num').fadeOut(2000);
				 setTimeout(function(){ $('.cap_num').remove(); }, 2000);
			}
				
			
			var pass=$('#user_password').val();
			var con=$('#confirm_password').val();
			if(pass!='' && pass.length<8){
				
				$('#user_password').next('span').fadeIn('fast');
				$('#user_password').next('span').html("Password should be between 8 to 20 characters.");
				formError=true;
					return false;
			}else{
					$('#user_password').next('span').fadeOut(2000);
			}
		
			if(con!='' && pass!=con){
				$('#confirm_password').next('span').fadeIn('fast');
				jQuery('.pass_error').show();
				$('#confirm_password').next('span').html("Password does not match!");
				formError=true;
				return false;
			}
			if(con==''&& pass.length>=8){
				$('.pass').next('span').fadeOut(2000);
			}
			if(pass==con && pass.length>=8){
				$('.pass').next('span').fadeOut(2000);
			}
			formError=false;
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
	 * This function for date picker
	 *---------------------------------------------------------------------------------------
	 */ 
		$( ".datepicker" ).datepicker({
			format: 'dd-m-yyyy',
			endDate: '+0d',
			autoclose: false,
		}).on('changeDate', function(e){
			$(this).datepicker('hide');
		});

	
});
