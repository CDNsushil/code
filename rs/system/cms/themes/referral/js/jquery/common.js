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
	var formError=false;
 /*
 *--------------------------------------------------------------------------------------- 
 * This is common funtion for desigining purpose
 *---------------------------------------------------------------------------------------
 * @parm1 = @void
 */ 
 $( document).ready(function() {
	// $('.carousel').carousel();
		function equalHeight(group) {
			tallest = 0;
			group.each(function() {
				thisHeight = $(this).height();
				if(thisHeight > tallest) {
					tallest = thisHeight;
				}
			});
			group.height(tallest);
		}

		equalHeight($(".blockheight"));
		$('#LoginCaptcha_SoundIcon').remove();
		$('#LoginCaptcha_CaptchaImageDiv').find('a').remove();
	});
		
        
 /*
 *--------------------------------------------------------------------------------------- 
 * This function is used to not allowed user of key bord and cut copy past option
 *---------------------------------------------------------------------------------------
 * @parm1 = @void
 */ 
$( document).ready(function() {
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
				formError=true;
				return false;
			}	
			$(this).next('span').fadeOut(2000);
		});	
	$(".alpha_num").blur(function(e) {
		if(((e.which>=34 && e.which<=47) || (e.which>=58 && e.which<=64) || (e.which>=91 && e.which<=96) || (e.which>=123 && e.which<=126)) && e.which!=45)
		{
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter alpha/numeric charactor only.');
			formError=true;
			return false;
		}	
		$(this).next('span').fadeOut(2000);
		formError=false;
	});	
	
	 
    /*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to allowed only numeric value
	 *---------------------------------------------------------------------------------------
	 * @parm1 = @void
	 */ 
	 
	 $(".numeric").keypress(function(e) {
		 
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)))
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('Please enter valid digit.');
				formError=true;
				return false;
			}	
			
			$(this).next('span').fadeOut(2000);
		});
		$(".numeric").blur(function(e) {
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0))){
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid digit.');
			formError=true;
			return false;
		}	
		formError=false;
		$(this).next('span').fadeOut(2000);
	});	
	
	 /*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to allowed only price with dit(.) value
	 *---------------------------------------------------------------------------------------
	 * @parm1 = @void
	 */ 
	 
	 $(".validPrice").keypress(function(e) {

			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)) && e.which!=46)
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('Please enter valid price.');
				formError=true;
				return false;
			}	
			
			$(this).next('span').fadeOut(2000);
		});
		$(".validPrice").blur(function(e) {
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)) && e.which!=46)		{
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid price.');
			formError=true;
			return false;
		}	
		formError=false;
		$(this).next('span').fadeOut(2000);
	});	
	
		 
       /*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to for password
	 *---------------------------------------------------------------------------------------
	 * @parm1 = @void
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
	 * This function is used to prevent copy  & paste
	 *---------------------------------------------------------------------------------------
	 */ 	
		
		 $('.copy_paste').bind("copy paste",function(e) {
			  e.preventDefault();
		 });
		
				
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to check email address formate
	 *---------------------------------------------------------------------------------------
	 */ 
	 $('.email').blur(function(){
	
		var txt = $(this).val();
		if(txt==''){
			$(this).next('span').fadeOut(2000);
			return true;
		}
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
	 * This function is used to check valid phone
	 *---------------------------------------------------------------------------------------
	 */ 
	
	$('.valid_phone').blur(function(){
		 
		 var value = $(this).val();
		 if(value==''){
			 $(this).next('span').fadeOut(2000);
			 return true;
		 }		 
		 
		var validPhone = /^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{5,12}){1,2}(\s*(ext|x)\s*\.?:?\s*([0-9]+))?$/;
		var pattern=validPhone.test(value);
		if(!pattern){
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid phone.');
			formError=true;
		}else{
			$(this).next('span').fadeOut(2000);
			formError=false;
			return true;
		}
		return false;
	});
	
	 $(".valid_phone").keypress(function(e) {
		
		if(((e.which!=43) && (e.which!=45) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)))
		{
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid phone.');
			formError=true;
			return false;
		}	
		
		$(this).next('span').fadeOut(2000);
	});

	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to change captcha code
	 *---------------------------------------------------------------------------------------
	 */ 
	 
	$('.change_captcha').click(function(){
		
			$.ajax({
			  type: "POST",
			  url: baseUrl+'users/getCapchaCode',
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
		var price=$('#memPrice'+id).val();
		 if(price>0){
			 price=' (Price $'+price+')';
		 }else{
			 price='';
		 }
		$('.feature_head').html(option+price);
			 //$(".paypal_img").attr("href",baseUrl+"membership/paypalPayment/"+id);
			$.ajax({
			  type: "POST",
			  url: baseUrl+'membership/getSelectMembership',
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
			var url = $(this).attr('href');
		
			bootbox.confirm("Are you sure you want to delete?",function(result){
		
				if(result==true){
						window.location.href=url;
					}else{
						bootbox.hideAll();
						return false;
					}
			});
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
		bootbox.alert('Please select at least on option.');
		return false;
	});
	
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function used to open popup for email
	 *---------------------------------------------------------------------------------------
	 */
	 $('.email_icon').click(function(){
			
			 if (jQuery('#add_testimonial').is(":checked")) {
				$('#product_testi').val('1');
			}else{
				$('#product_testi').val('0');
			}
			$('#email_popup').modal({ backdrop: 'static', keyboard: true });
			return true;
		});
	
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function used to open product testimonial popup box
	 *---------------------------------------------------------------------------------------
	 */
	 $('.addProductTesti').click(function(){
	
		  if (jQuery('#add_testimonial').is(":checked")) {
			$('#product_testi').val('1');
			$('#add_product_testi').modal({ backdrop: 'static', keyboard: true });
			return true;
		}else{
			$('#product_testi').val('0');
			return true;
		}
	});
	
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function used to open login popup box
	 *---------------------------------------------------------------------------------------
	 */
	 $('.affiLogin').click(function(){
		
		$('#myModal').modal({ backdrop: 'static', keyboard: true });
		return true;
	});
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function used to open direct deposit term & condition popup box
	 *---------------------------------------------------------------------------------------
	 */ 
	 $('.direct_deposit').click(function(){
		
		$('#direct_deposit').modal({ backdrop: 'static', keyboard: true });
		return true;
	});
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function used to open term & condition popup box
	 *---------------------------------------------------------------------------------------
	 */ 
	 $('.term_cond').click(function(){
		$('#term_condi').modal({ backdrop: 'static', keyboard: true });
		return true;
	});
    
    $('.pageContentsEdit').click(function(){
		$('#pageContentsEdit').modal({ backdrop: 'static', keyboard: true });
		return true;
	});
	
	
	/*
 *--------------------------------------------------------------------------------------- 
 * This function used to check referral point
 *---------------------------------------------------------------------------------------
 */ 
	$('.referral_point').blur(function(){
		var defaultPoint=$('#default_referral_point').val();
		var cDefault=parseInt(defaultPoint)-1;
		var enterPoint=$('.referral_point').val();
		var isNumeric=$.isNumeric(enterPoint);
		if(!isNumeric){
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter valid digit.');
			formError=false;
			return true;
		}
		if(cDefault >= enterPoint){
	
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Referral point should be greater than '+cDefault+'.');
			formError=true;
			return true;
		}else{
		
			$(this).next('span').fadeOut('fast');
			formError=false;
		}
	});
	
	$('#banner_price').change(function(){
		var value=$(this).val();
		var option=$("#banner_price option[value="+value+"]").text();
	
		$('#banner_size').val(option);
		$('.banner_price').html(value);
		
	});
	
 /*
 *--------------------------------------------------------------------------------------- 
 * This function for date picker
 *---------------------------------------------------------------------------------------
 */ 
	$( ".datepicker" ).datepicker({
		format: 'dd-m-yyyy',
		endDate: '-10y',
		autoclose: false,
	}).on('changeDate', function(e){
		$(this).datepicker('hide');
	});
	
	
});

function postFormGetHTML(formId,divID,closePopup,ShowMsg,refresh){
       var fromData=$(formId).serialize(); 
       var action=$(formId).attr('action');
       var result = ajaxHTML(action,divID,fromData,closePopup,ShowMsg,refresh);
       if(result){
           if(closePopup != undefined && closePopup != ''){
                $(closePopup).click();
            }
            if(ShowMsg != undefined && ShowMsg != ''){
               notificatinshow(ShowMsg,'success');
            }
            if(refresh != undefined && refresh == 1){
               window.location.reload(true);
            }
       }
}

function ajaxHTML(url,divID,data){
   var returnFlag= false;
   $.ajax({
      type: 'POST',
      url : url,
      dataType :'html',
      data : data,		
      beforeSend:function(){
        if(divID != undefined && divID != ''){
            $(divID).html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
        }
      },
      success:function(data){
        if(data){
            returnFlag= true;
            if(divID != undefined && divID != ''){
                $(divID).html(data);
            }
        }
      },
      async:false,
        error: function (xhr, ajaxOptions, thrownError) {
        alert(thrownError);
      }
    });
    return returnFlag;
}



	
