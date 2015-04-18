<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$formAttributes = array(
'name'=>'ajaxForm',
'id'=>'ajaxForm',
'autocomplete'=>'off'
);

$LabelAttributes = array(
'class'=>'orng width115px'
);

$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'class'	=> 'width_338 required email',
	'title'=>$this->lang->line('auth_label_EmailValidation'),
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'class'	=> 'width_338 required',
	'title'=>$this->lang->line('auth_label_passwordValidation'),
	'value' => set_value('password'),
	'minlength'	=> 8,
	'maxlength'	=> 20,
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'class'	=> 'width_338 required',
	'equalTo'	=> '#password',
	'title'=>$this->lang->line('auth_label_confirmPasswordValidation'),
	'value' => set_value('confirm_password'),
	'minlength'=>8,
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30
);
$firstName = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class'	=> 'width_338 required',
	'title'=>$this->lang->line('auth_label_firstnameValidation'),
	'value'	=> set_value('firstName'),
	'minlength'	=> 2,
	'maxlength'	=> 25,
	'size'	=> 30
);
$lastName = array(
	'name'	=> 'lastName',
	'id'	=> 'lastName',
	'class'	=> 'width_338',
	'title'=>$this->lang->line('auth_label_lastnameValidation'),
	'value'	=> set_value('lastName'),
	'minlength'	=> 2,
	'maxlength'	=> 25,
	'size'	=> 30
);
$city = array(
	'name'	=> 'cityName',
	'id'	=> 'cityName',
	'class'	=> 'width_338',
	'title'=>$this->lang->line('auth_label_cityValidation'),
	'value'	=> set_value('city'),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'class'	=> 'width_338 required',
	'title'=>$this->lang->line('auth_label_enterTheWordsAbove'),
	'minlength'	=> 8,
	'maxlength'	=> 8
);
$terms = array(
	'name'	=> 'terms',
	'id'	=> 'terms',
	'class'	=> 'width150px',
	'value' => 1,
	'disabled' => true
);
?>
	
<style type="text/css">
  .checkboxWrapper {
    position: relative;
  }
  .checkboxOverlay {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
  }
</style>

<script type="text/javascript">
  function notify() {
    alert("Hello");
  }
</script>	
	
	
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="bg_white">
    <div class="width865px pt1" id="dataStorage">
	<!--<div class="join_heading ml88 pt10 pr">
		<div class="Fleft"><?php //echo $this->lang->line('join')?></div></div>-->
		<div id="successMsg"></div>	
	<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
		<div class="pop_bdr"></div>
		
		 <div class="torcmsg_heading clr_white font_size24 pl70 font_opensans">
			<div class=" pt18 fl font_arial"><?php echo $this->lang->line('join')?></div> 
			<div class="fr mt13 mr23"><img src="<?php echo base_url('images/join-popup_logo.png');?>" /></div>
		</div>
		
		<!-- Div for top btns-->
		<div class="row position_relative ml_25 height98">
        <div class="font_opensansSBold font_size15 clr_666 fl lineH38 mt20">
        <span class="fl"><?php echo $this->lang->line('alreadyMember')?> </span>
         <div class="tds-button fl mt5 ml8 mr14"> <a href="javascript:openLightBox('popupBoxWp','popup_box','/auth/login/')" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" ><span class="dash_link_hover font_opensans width_65" ><?php echo $this->lang->line('login')?></span></a> </div>
        
        <div class="fl"><?php echo $this->lang->line('loginOrJoinFacebook')?></div>
       
        <div class="fl mt4 ml12">
			<!--<a href="<?php //echo getFacebookLoginUrl(); ?>" onclick="return openLightBoxWithoutAjax('popupBoxWp','popup_box');" onmousedown="mouseup_fbloginB(this)" onmouseup="mouseup_fblogin(this)" class="fbbutton_toad_login" ></a>-->
			<a href="javascript:void(0);" onclick="open_window('<?php echo getFacebookLoginUrl(); ?>'); $(this).parent().trigger('close');" onmousedown="mouseup_fbloginB(this)" onmouseup="mouseup_fblogin(this)" class="fbbutton_toad_login" ></a>
		</div>
               
        </div>
        
        <div class="fr font_opensansSBold font_size13 clr_363636 width_230 bdrL_5 pl10 mr28 lineH16 mt15">
       <?php echo $this->lang->line('joinWithFacebook')?>
        </div>
        
        <div class="joinlogin_brrb"></div>
        <div class="clear"></div>
        </div>
		<!-- Div for top btns-->
		<div class="mt-10 mb10">
			<div class="fl">
				<div class="fl position_relative">
					<div class="cell shadow_wp strip_absolute left_170">
						<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr>
								  <td height="59"><img src="<?php echo base_url('images/shadow-top-small.png');?>"></td>
								</tr>
								<tr>
								  <td class="shadow_mid_small">&nbsp;</td>
								</tr>
								<tr>
								  <td height="63"><img src="<?php echo base_url('images/shadow-bottom-small.png');?>"></td>
								</tr>
							</tbody>
						</table>
						<div class="clear"></div>
					</div>
					<div class="seprator_27"></div>
					<div class="row">
						<div class="join_label_wrapper cell">
							<label class="req_field"><?php echo $this->lang->line('auth_label_email')?></label>
						</div>
						<div class=" cell join_frm_element_wrapper">
							<?php echo form_input($email); ?>
							<div class="drkGrey" id="emailMsg"></div>
						</div>
					</div>
					<div class="row">
						<div class="join_label_wrapper cell">
							<label class="req_field"><?php echo $this->lang->line('auth_label_password')?></label>
						</div>
						<div class=" cell join_frm_element_wrapper">
							<?php echo form_password($password); ?>
						</div>
					</div>
					<div class="row">
						<div class="join_label_wrapper cell">
							<label class="req_field"><?php echo $this->lang->line('auth_label_confirmPassword')?></label>
						</div>
						<div class=" cell join_frm_element_wrapper">
							<?php echo form_password($confirm_password); ?>
						</div>
					</div>
					<div class="row">
						<div class="join_label_wrapper cell">
							<label class="req_field"><?php echo $this->lang->line('auth_label_firstName')?></label>
						</div>
						<div class=" cell join_frm_element_wrapper">
							<?php echo form_input($firstName); ?>
						</div>
					</div>
					<div class="row">
						<div class="join_label_wrapper cell">
							<label><?php echo $this->lang->line('auth_label_lastName')?></label>
						</div>
						<div class=" cell join_frm_element_wrapper">
							<?php echo form_input($lastName); ?>
						</div>
					</div>
					<div class="row">
						<div class="join_label_wrapper cell">
							<label class="req_field"><?php echo $this->lang->line('auth_label_country')?></label>
						</div>
						<div class=" cell join_frm_element_wrapper">
							<div class="fl pr">
								<?php
								$countries = getCountryList();
								echo form_dropdown('country', $countries, set_value('country'),'id="countriesList" class=" width250px required l0px mb15 zindex10000"');
							  ?>
							</div>
						</div>
					</div>
					<?php /*
					<div class="row">
					<div class="join_label_wrapper cell">
					<label><?php echo $this->lang->line('auth_label_city')?></label>
					</div>
					<div class=" cell join_frm_element_wrapper">
					<?php echo form_input($city); ?>
					</div>
					</div>
					<? */?>
					<!--<div class="row">
						<div class="join_label_wrapper cell"> </div>
						div class=" cell join_frm_element_wrapper">
						<div class="Req_fld font_opensansSBold font_size12 mt2"><?php echo $this->lang->line('requiredFields')?>  </div>
						</div
					</div>-->
				</div>
					
				<div class="row font_opensansLight font_size18 clr_888 letter_spaceP-1 ml24 fl mt30">
					<?php echo $this->lang->line('scrollNReadTerm')?>
				</div>
			</div>
			
				<div class="fl width_250 ml40 mt28">
					<div class="row font_opensans font_size13 clr_666 bdrL_5_666 pl10 lineH16">
						<?php echo $this->lang->line('keepARecordOfPassword')?>
					</div>
					<div class="seprator_24"></div>
					<div class="row font_opensans font_size13 clr_666 bdrL_5_666 pl10 lineH16">
						<?php echo $this->lang->line('checkEmailFolder')?>
						<br><br>
						<?php echo $this->lang->line('emailFilter')?>
					</div>
			  
					<div class="seprator_24"></div>
			   
					<div class="row font_opensans font_size13 clr_666 bdrL_5_666 pl10 lineH16">
						<?php echo $this->lang->line('notReceiveWelcomeEmail')?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		<!--popupscrollbar_bg for terms N condition -->
		<div class="seprator_5"></div>
		<div class="popupscrollbar_bg">
			<div class="NIC height320 content_3 content" id="termConditionBox">
				<?php echo $description; ?>
			</div>
			 <div class="seprator_22"></div>
			 <div class="row height20"><img alt="joinscroll" src="<?php echo base_url('images/joinscroll_shedow.png');?>"/></div>
			 <div class="clear"></div>
			 <div class="row">
				<div class="cell">
					<div class="defaultP">
						<div class="dn" id="check_input"><?php echo form_checkbox($terms); ?></div>
						<div class="ez-checkbox" id="check_img"></div>
					</div>
				</div>
				<div class="cell font_opensansSBold font_size12">
					<?php echo $this->lang->line('joinMsgTermsOfServices1'); ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="row font_opensansSBold font_size12 clr_444 fr">
				<a href="<?php echo site_url(lang()).'/cms/downloadtandc';?>" target="_blank" class="text_deco_U fl mr8 a_orange mt15"><?php echo $this->lang->line('joinMsgTermsOfServices2'); ?></a>
				<div class="fr mr15"><img alt="pdf" src="<?php echo base_url('images/joinpdf_icon.png');?>"></div>
            </div>
			<div class="clear"></div>
		
			<div class="row dn orange f12" id="term_error">
				<?php echo $this->lang->line('thisFieldIsReqforJoin'); ?>
			</div>
			<!-- error text for desable check -->
			<div class="row dn 12" id="disable_check_error">
				<?php echo $this->lang->line('joinDesableCheck'); ?>
			</div>
			<input type="hidden" name="term_hidden_val" id="term_hidden_val" value="">
			<input type="hidden" name="join_hidden_val" id="join_hidden_val" value="">
			<div class="clear"></div>
        </div> 
        <!-- / popupscrollbar_bg --> 
        
		<div class="seprator_24"></div>
		<div class="row">
            <div class=" cell join_frm_element_wrapper mH18 pl21">
              <div class="Req_fld font_opensansSBold font_size12 mt2"> <?php echo $this->lang->line('requiredFields')?> </div>
            </div>
        </div>
		
		<div class="seprator_22"></div>
		<div class="bdr_Borange ml20 mr20"></div>
		<div class="row">
            <div class=" cell join_frm_element_wrapper mH25 pl21">
              <div class="font_size12 mt2">* <?php echo $this->lang->line('descReqFieldMsg')?></div>
            </div>
        </div>
		<div class="seprator_27"></div>
		<div class="row font_opensansSBold">
			<div class="tds-button-orange mr15 fr"> <a onclick="$('#ajaxForm').submit();" href="javascript:check_terms();" onmousedown="mousedown_tds_button_orange(this)" onmouseup="mouseup_tds_button_orange(this)"><span class="width_60"><?php echo $this->lang->line('join')?></span></a> </div>
        </div>
		<div class="clear"></div>
		
	<?php echo form_close(); ?>
	<div class="seprator_15 clear"></div>
	<div class="row">
	  <div class="cell"></div>
	  <div class="cell"></div>
	</div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url().'templates/system/javascript/jquery_customscroll.js';?>"></script>
<script type="text/javascript">
	
	selectBox();
	$(document).ready(function(){
		selectBox();	
		/*
		*******************************************
		Custom Form validation
		*******************************************
		*/
		//$('#email').focus();
		$("#ajaxForm").validate({
			
			// specifying a submitHandler prevents the default submit, good for the demo
			submitHandler: function() {
				if($('#terms').is(':checked') === false) {
					if($('#term_hidden_val').val() !=1 ) {
					$('#term_error').show();
				}
					return false;
				}   
				
				var email = $('#email').val();
				var password = $('#password').val();
				var confirm_password = $('#confirm_password').val();
				var firstName = $('#firstName').val();
				var lastName = $('#lastName').val();
				var countryId = $('#countriesList').val();
				var cityName = $('#cityName').val();
				doRegister('<?php echo base_url($this->uri->uri_string());?>',email,password,confirm_password,firstName,lastName,countryId,cityName);
			}
		});	
	});
	
	/*Function to acivate disabled checkbox */
	$(document).ready(function(){
		$('#termConditionBox').bind('scroll',chk_scroll);
	});

	function chk_scroll(e) 
	{
		outHeight = $('#termConditionBox').height();
		alert(outHeight);
		scrollHeight = $('#termConditionBox')[0].scrollHeight;
		scrollTop = $('#termConditionBox').scrollTop();
		if (scrollHeight - scrollTop == outHeight)
		{
			$('#terms').removeAttr('disabled');
			$(".ez-checkbox").css({ opacity: 1.5 });
			$('#term_hidden_val').val(1);
			$('#disable_check_error').hide();
			$('#check_img').hide();
			$('#check_input').show();
			if($('#terms').is(':checked') === false) {
			//$('#term_error').show();
			}
			console.log("bottom");
		}
	}
	
	/*Function to manage checkbox */
	$(function() {
		$('.defaultP input').ezMark();
		$('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'})
		$(".ez-checkbox").css({ opacity: 0.5});
	});	
	
	function check_terms()
	{	
		$('#disable_check_error').hide();  
		$('#join_hidden_val').val(1);
		if(($('#term_hidden_val').val()==1) && ($('#join_hidden_val').val()==1)) {
			if($('#terms').is(':checked') === false) {
				$('#term_error').show();

				$(".popupscrollbar_bg").height(425);

			}	
		}
		
		if($('#term_hidden_val').val()!=1) {
			if($('#terms').is(':checked') === false) {
				$('#term_error').show();

				$(".popupscrollbar_bg").height(425);

			}
		}
	}
	
	/*Function check condition on Click */
	$("#terms").click(function() {
		
		if(($('#term_hidden_val').val()==1) && ($('#join_hidden_val').val()==1)) {
			
			if($('#terms').is(':checked') === false) {
				$('#term_error').show();

				$(".popupscrollbar_bg").height(425);

			}
			else {
				$('#term_error').hide();
			}
		}
	});
	
	$("#check_img").click(function(){
		$('#disable_check_error').show();
		$('#term_error').hide();
    });
    
    setTimeout("load_work()",1000);
    
    function load_work(){
		$(".content_3").mCustomScrollbar({
			scrollInertia:600,
			autoDraggerLength:false,
			callbacks:{
			whileScrolling:function(){
				var top_drag = $('.mCSB_dragger').css('top');
				if(top_drag=='309px') {
					$('#terms').removeAttr('disabled');
					$(".ez-checkbox").css({ opacity: 1.5 });
					$('#term_hidden_val').val(1);
					$('#disable_check_error').hide();
					$('#check_img').hide();
					$('#check_input').show();
					console.log("bottom");
				}
			  }
			}
		});		
		//$("#termConditionBox").css("height","320");
	}

</script>

	

