<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$isNew_email = $this->session->userdata('new_email');
$isNew_password = $this->session->userdata('new_password');
//Display popup when new email entered
if($isNew_email && $isNew_email==1){
	$this->session->unset_userdata('new_email');
	$beforeChangeLoggedIn = $this->lang->line('beforeChangeLoggedIn');
	$newLoginEmail = $this->lang->line('newLoginEmail');
	?>
	<script>
		if(checkIsUserLogin('<?php echo $beforeChangeLoggedIn;?>')){
			customAlert('<?php echo $newLoginEmail;?>')
		}
	</script>
<?php
}
//Display popup when new password entered
if($isNew_password && $isNew_password==1){
	$this->session->unset_userdata('new_password');
	$beforeChangeLoggedIn = $this->lang->line('beforeChangeLoggedIn');
	$newLoginPassword = $this->lang->line('newLoginPassword');
	?>
	<script>
		if(checkIsUserLogin('<?php echo $beforeChangeLoggedIn;?>')){
			customAlert('<?php echo $newLoginPassword;?>')
		}
	</script>
<?php
}

$lang=lang();
$formAttributes = array(
	'name'=>'generalSettingForm',
	'id'=>'generalSettingForm'
);
$firstNameInput = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class'	=> 'required width_551',
	'value'	=> set_value('firstName')?set_value('firstName'):$userProfileData->firstName,
	'maxlength'	=> 50,
	'size'	=> 50
);
$lastNameInput = array(
	'name'	=> 'lastName',
	'id'	=> 'lastName',
	'class'	=> 'width_551',
	'value'	=> set_value('lastName')?set_value('lastName'):$userProfileData->lastName,
	'maxlength'	=> 50,
	'size'	=> 50
);
$cityNameInput = array(
	'name'	=> 'cityName',
	'id'	=> 'cityName',
	'class'	=> 'widht_248',
	'value'	=> set_value('cityName')?set_value('cityName'):$userProfileData->cityName,
	'maxlength'	=> 50,
	'size'	=> 50
);
$passwordInput = array(
	'type'	=> 'password',
	'name'	=> 'password',
	'id'	=> 'password',
	'class'	=> 'width_551',
	'value'	=> '',
	'minlength'	=> 8,
	'maxlength'	=> 50,
	'size'	=> 50
);
$confirmPasswordInput = array(
	'type'	=> 'password',
	'equalto'	=> '#password',
	'name'	=> 'confirmPassword',
	'id'	=> 'confirmPassword',
	'class'	=> 'width_551',
	'title' => $this->lang->line('reqConfirmPasswordMsg'),
	'value'	=> '',
	'minlength'	=> 8,
	'maxlength'	=> 50,
	'size'	=> 50
);
$generalSettingsInput = array(
	'name'	=> 'generalSettings',
	'type'	=> 'hidden',
	'id'	=> 'generalSettings',
	'value'	=>'generalSettings'
);

if(!empty($userProfileData->new_email_key)){
	$secClass = 'width250px email';
}else{
	$secClass = 'width_551 email';
}

$newEmail = array(
	'name'	=> 'new_email',
	'id'	=> 'new_email',
	'class'	=> $secClass,
	'value'	=> set_value('new_email')?set_value('new_email'):$userProfileData->new_email,
	'maxlength'	=> 50,
	'size'	=> 50
);
$newEmailHiddenInput = array(
	'name'	=> 'checkEmail',
	'type'	=> 'hidden',
	'id'	=> 'checkEmail',
	'value'	=> ''
);
$PrimaryEmailHiddenInput = array(
	'name'	=> 'primaryEmail',
	'type'	=> 'hidden',
	'id'	=> 'primaryEmail',
	'value'	=> set_value('primaryEmail')?set_value('primaryEmail'):$userProfileData->email,
);
$newEmailKeyHiddenInput = array(
	'name'	=> 'new_email_key',
	'type'	=> 'hidden',
	'id'	=> 'new_email_key',
	'value'	=> set_value('new_email_key')?set_value('new_email_key'):$userProfileData->new_email_key,
);
$swapEmail = array(
	'name'      => 'swapEmail',
	'id'        => 'swapEmail',
	'value'     => 1 ,
);

if(!empty($userProfileData->new_email)){
	$secEmailVal = $userProfileData->new_email;
}else{
	$secEmailVal = '';
}

?>
<div class="row tab_wp pt2 ">
      <div class="row ">
        <div class="cell tab_left width_202">
          <div class="tab_heading_global"><?php echo $this->lang->line('generalSettings');?></div>
        </div>
        <div class="cell tab_right width_590">
          <div class="tab_btn_wrapper">
            <div class="tds-button-top">
				<a class="formTip"><span><div toggledivid="NEWS-Content-Box2" class="projectToggleIcon"></div></span></a>
			</div>
          </div>
        </div>
      </div>
      <!--row-->
      <div class="clear"></div>
      <div id="NEWS-Content-Box2" class="form_wrapper toggle pr5">
   <?php echo Modules::run("common/strip");
		echo form_open($this->uri->uri_string(),$formAttributes); 
			$validation_errors= validation_errors();
		?>
			<div class="row">
			  <div class="tab_shadow tab_shadow_g"> </div>
			</div>
			
			<div class="shadow_sep row"> </div>
			<div class="clear"></div>
			<div class="seprator_10"> </div>
			<div class="upload_media_left_top2 row"></div>
					
			<div class="upload_media_left_box">
			  <div class="seprator_10"> </div>
			 <?php
			 if(isset($validation_errors) && $validation_errors && !empty($validation_errors)){ ?>
				<div class="row width_791">
					<div class="label_wrapper_global cell bg-non"></div>
					<!--label_wrapper-->
					<div class=" cell frm_element_wrapper pl14">
					  <?php echo $validation_errors; ?>
					</div>
				</div>
				<?php
			 }
			 ?>
			 
			  <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label class="select_field_g"><?php echo $this->lang->line('auth_label_firstName');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper pl14">
				  <?php echo form_input($firstNameInput); ?>
				</div>
			  </div>
			  
			  <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('auth_label_lastName');?></label>
				</div>
				<!--label_wrapper-->
				<div class="cell frm_element_wrapper pl14">
				   <?php echo form_input($lastNameInput); ?>
				</div>
			  </div>
			  
			 <!-- Div for Primary Email -->
			   <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label class="select_field_g"><?php echo $this->lang->line('auth_label_email');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper pl14">
				  <div class="disable_div"> <?php echo $userProfileData->email;?> </div>
				</div>
			  </div>
			  
			<!-- Secondary Email Start-->
					<div class="row width_791">
						<div class="label_wrapper_global cell">
						  <label><?php echo $this->lang->line('auth_label_second_email');?></label>
						</div>
						<!--label_wrapper-->
						<div class=" cell frm_element_wrapper pl14 <?php echo $secClass;?>">
							<?php echo form_input($newEmail);?>
							<div id="emailMsg" class="dn clr_888"><?php echo $this->lang->line('secondaryEmailExists');?></div>
							<div id="validEmailMsg" class="drkGrey dn"><?php echo $this->lang->line('validSecondaryEmail');?></div>
						</div>
						<!---Div for swaping email if secondary mail exist-->
						<?php if(!empty($userProfileData->new_email)){?>
						<div class="cell frm_element_wrapper pl14 fr widht_304">
							<div class="defaultP mt5 fl formTip ml-6" original-title="<?php echo $this->lang->line('makePrimaryToolTip');?>">
								<?php echo form_checkbox($swapEmail);?>
							</div>
							<div class="row fr mt-27 font_opensans font_size11 clr_888 widht_275 mr10"><?php echo $this->lang->line('makePrimarystart');?><b><?php echo $this->lang->line('makePrimaryEnd');?></b>
						</div></div>
						<?php }?>
					</div>
			 <!-- Secondary Email END-->
			  
			   <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label class=""><?php echo $this->lang->line('auth_label_new_password');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper pl14">
				   <?php echo form_input($passwordInput); ?>
				</div>
			  </div>
			  
			  
			  <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label class=""><?php echo $this->lang->line('auth_label_confirmPassword');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper pl14">
				  <?php echo form_input($confirmPasswordInput); ?>
				</div>
			  </div>
			  
			  
			  <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label class="select_field_g"><?php echo $this->lang->line('country');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper pl14 ml2">
					  <?php
							$countryId=$userProfileData->countryId;
							$countryId=set_value('countryId')?set_value('countryId'):$countryId;
							echo form_dropdown('countryId', $countryList, $countryId,'id="countryId" class="required l12"');
					  ?>
				 </div>
			  </div>
			<div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('auth_label_town_city');?></label>
				</div>
				<!--label_wrapper-->
				<div class=" cell frm_element_wrapper pl14">
				 <a class="formTip" title="This will appear on your Showcase Homepage as well as making it easier to find you in our search.">
				   <?php echo form_input($cityNameInput); ?>
				  </a>
				</div>
			  </div>
			  
			   <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('originalLanguage');?></label> 
				</div>
				<!--label_wrapper-->
				
				<div class="cell frm_element_wrapper pl14">
				 
				 <?php
					$firstLang=$userProfileData->firstLang;
					$firstLang=set_value('firstLang')?set_value('firstLang'):$firstLang;
					$language = getlanguageList();
					echo form_dropdown('firstLang', $language, $firstLang,'id="firstLang" class="l12 formTip" title="This will appear on your Showcase Homepage as well as making it easier to find you in our search."');
				 ?>
				</div>
			  </div>
			  
			   <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('industry');?></label>
				</div>
				<!--label_wrapper-->
				 <div class=" cell frm_element_wrapper pl14">
					<?php 
						$industryId=$userProfileData->industryId;
						$industryId=set_value('industryId')?set_value('industryId'):$industryId;
						$industryList = getIndustryList();
						echo form_dropdown('industryId', $industryList, $industryId,'id="industryId" class="l12 formTip" title="This will appear on your Showcase Homepage as well as making it easier to find you in our search."');
					 ?>
				 </div>
			  </div>
			   
			   <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('auth_label_display_language');?></label>
				</div>
				<!--label_wrapper-->
				<div class="cell frm_element_wrapper pl14">
				 <?php
					$displayLang=$userProfileData->displayLang;
					$displayLang=set_value('displayLang')?set_value('displayLang'):$displayLang;
					//$language = getlanguageList();
					//echo form_dropdown('displayLang', $language, $displayLang,'id="displayLang" class="l12"');
					//echo 'English';
				 ?>
				 <div class="disable_div"> <?php echo $this->lang->line('English'); ?> </div>
				 <input type="hidden" name="displayLang" value="1">
				</div>
			  </div>
			  
			  <div class="row">
			  <div class="label_wrapper cell bg-non"> </div>
			  <!--label_wrapper-->
			  <div class=" cell frm_element_wrapper pl25">
				<div class="Req_fld mr30 mt0"><?php echo $this->lang->line('requiredFields');?><div class="clear"> </div></div>
				<div class="cell mr30 greyMsg">* <?php echo $this->lang->line('req_field_msg');?></div>
			  </div>
			</div>
			<div class="clear"> </div>
			  <div class="seprator_10"></div>
			  <!--from_element_wrapper-->
			  <div class="clear"> </div>
			</div>
			
		   

			<div class="upload_media_left_bottom row"> </div>
			 <div class="row">
					<div class="cell label_wrapper"><div class="lable_heading_g"><h1><?php echo $this->lang->line('searchPreferences');?></h1></div></div>
					<div class="cell frm_element_wrapper pl14 font_opensans font_size12 clr_888 pt12">
					<?php echo $this->lang->line('searchPreferencesMsg');?>
					</div>
			 </div>
			<!--from_element_wrapper-->
			<div class="clear"></div>
			<div class="upload_media_left_top2 row"> </div>
			<div class="upload_media_left_box"> 
			<div class="seprator_10"> </div>
			<div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('auth_label_first_language');?></label>
				</div>
				<!--label_wrapper-->
				 <div class=" cell frm_element_wrapper pl14 ml2">
						<?php
							$firstLanguage=$userProfileData->firstLanguage;
							$firstLanguage=set_value('firstLanguage')?set_value('firstLanguage'):$firstLanguage;
							//$language = getlanguageList();
							echo form_dropdown('firstLanguage', $language, $firstLanguage,'id="firstLanguage" class="l12"');
						 ?>
				  </div>
			  </div>
			  
			  
			  <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('auth_label_second_language');?></label>
				</div>
				<!--label_wrapper-->
				 <div class=" cell frm_element_wrapper pl14 ml2">
					   <?php
							$secondLanguage=$userProfileData->secondLanguage;
							$firstLanguage=set_value('secondLanguage')?set_value('secondLanguage'):$secondLanguage;
							echo form_dropdown('secondLanguage', $language, $secondLanguage,'id="secondLanguage" class="l12"');
						 ?>
				  </div>
			  </div>
			  
			  
			  <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('auth_label_first_country');?></label>
				</div>
				<!--label_wrapper-->
				 <div class=" cell frm_element_wrapper pl14 ml2">
						<?php
							$firstCountryId=$userProfileData->firstCountryId;
							$firstCountryId=set_value('firstCountryId')?set_value('firstCountryId'):$firstCountryId;
							echo form_dropdown('firstCountryId', $countryList, $firstCountryId,'id="firstCountryId" class="l12"');
						?>
					</div>
			  </div>
			  
			  
			  <div class="row width_791">
				<div class="label_wrapper_global cell">
				  <label><?php echo $this->lang->line('auth_label_second_country');?></label>
				</div>
				<!--label_wrapper-->
				 <div class=" cell frm_element_wrapper pl14 ml2">
						 <?php
							$secondCountryId=$userProfileData->secondCountryId;
							$secondCountryId=set_value('secondCountryId')?set_value('secondCountryId'):$secondCountryId;
							echo form_dropdown('secondCountryId', $countryList, $secondCountryId,'id="secondCountryId" class="l12"');
						?>
					</div>
			  </div>
			  <div class="clear"> </div>
			  <div class="seprator_8"> </div>
			</div>
			<div class="upload_media_left_bottom row"> </div>
				<div class="row">
					<div class="cell label_wrapper">
						<div class="lable_heading_g"><h1><?php echo $this->lang->line('ratingSelection');?></h1></div>
					</div>
					<div class="cell frm_element_wrapper pl14 font_size12 pt12">
					 <a class="formTip clr_888 font_opensans" title="<?php echo $this->lang->line('ratingSelectionTooltip');?>"><?php echo $this->lang->line('ratingSelectionMsg');?></a>
					</div>
				</div>
					
					<div class="clear"> </div>
					<div class="seprator_20"></div>
					<div class="upload_media_left_top2 row"></div>
							
					<div class="upload_media_left_box"> 
						<div class="label_wrapper_global cell"></div>
			
							<div class=" cell frm_element_wrapper pl14 pl5 widht_580 font_opensans clr_666">
							<div class="seprator_10"> </div>
							  <div class="price_trans_wp">
							  <div class="defaultP ml20 mt2">
								  <?php 
									$suitableForGeneralAudiences=$userProfileData->suitableForGeneralAudiences;
									$suitableForGeneralAudiences=set_value('suitableForGeneralAudiences')?set_value('suitableForGeneralAudiences'):$suitableForGeneralAudiences;
									$checked=($suitableForGeneralAudiences=='t')?'checked':'';
									echo '<input type="checkbox" '.$checked.' value="t" id="suitableForGeneralAudiences" name="suitableForGeneralAudiences" />';
								  ?>
								</div>
								<div class="cell ml10 mt4"><?php echo $this->lang->line('suitableForGeneralAudiences');?></div>
							  </div>
							  
							  <div class="clear"> </div>
							  <div class="price_trans_wp">
							  <div class="defaultP ml20 mt2">
								
									<?php 
									$suitableForChildren=$userProfileData->suitableForChildren;
									$suitableForChildren=set_value('suitableForChildren')?set_value('suitableForChildren'):$suitableForChildren;
									$checked=($suitableForChildren=='t')?'checked':'';
									echo '<input type="checkbox" '.$checked.' value="t" id="suitableForChildren" name="suitableForChildren" />';
								  ?>
								</div> 
								<div class="cell ml10 mt4"><?php echo $this->lang->line('suitableForChildren');?></div>
							  </div>
							  <div class="clear"> </div>
							  
							  <div class="price_trans_wp">
							  <div class="defaultP ml20 mt2">
								<?php 
									$suitableForYoungAdults=$userProfileData->suitableForYoungAdults;
									$suitableForYoungAdults=set_value('suitableForYoungAdults')?set_value('suitableForYoungAdults'):$suitableForYoungAdults;
									$checked=($suitableForYoungAdults=='t')?'checked':'';
									echo '<input type="checkbox" '.$checked.' value="t" id="suitableForYoungAdults" name="suitableForYoungAdults" />';
								?>
								</div>
								<div class="cell ml10 mt4"><?php echo $this->lang->line('suitableForYoungAdults');?></div>
							  </div>
							  
							  <div class="clear"> </div>
							  <div class="price_trans_wp">
							  <div class="defaultP ml20 mt2">
								<?php 
									$someContentCouldBeOfens=$userProfileData->someContentCouldBeOfens;
									$someContentCouldBeOfens=set_value('someContentCouldBeOfens')?set_value('someContentCouldBeOfens'):$someContentCouldBeOfens;
									$checked=($someContentCouldBeOfens=='t')?'checked':'';
									echo '<input type="checkbox" '.$checked.' value="t" id="someContentCouldBeOfens" name="someContentCouldBeOfens" />';
								?>
								</div>
								<div class="cell ml10 mt4"><?php echo $this->lang->line('someContentCouldBeOfensive');?></div>
							  </div>
							  
							   <div class="clear"> </div>
							   <div class="tag_word_orange mr30 clr_E76D34 font_size11 mt4 font_opensans ml60"><?php echo $this->lang->line('adultsMaterialNotAllowed');?>
							   <div class="clear"> </div>
							  </div>
						 </div>
						 <div class="clear"> </div>
						  <div class="seprator_10"> </div>
					 </div>
			 
					<div class="upload_media_left_bottom row"> </div>
					<div class="clear"></div>
					 
					<div class="row width_791">
						<div class="label_wrapper_global cell bg-non"></div>
						<!--label_wrapper-->
						 <div class=" cell frm_element_wrapper pl14 ml2  mt5 mb5">
							 <?php $deleteAccount_popup=$this->load->view("deleteAccount_popup",'',true); ?>
								<script>
									var deleteAccount_popup=<?php echo json_encode($deleteAccount_popup);?>;
								</script>
								<div class="fl pt7">
									<a href="javascript:void(0);" class="orange" onclick="loadPopupData('popupBoxWp','popup_box',deleteAccount_popup)"><?php echo $this->lang->line('deleteYourAccount');?></a>
								</div>
								<div class="fr">
									<?php
										echo form_input($newEmailHiddenInput);
										echo form_input($PrimaryEmailHiddenInput);
										echo form_input($newEmailKeyHiddenInput);
										echo form_input($generalSettingsInput);
										$button=array('save');
										$this->load->view("common/button_collection",array('button'=>$button)); 
									 ?>
							   </div> 
						</div>
					 </div>
			<?php echo form_close(); ?>                
      	</div> <!--tab_wp-->
      <div class="clear"></div>
</div>
<script>
$(document).ready(function(){
	$("#generalSettingForm").validate();
	
	/*Check secondary email with other email ids*/
	$("#new_email").blur(function(){
		var secEmail = $('#new_email').val();
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if( !emailReg.test( secEmail ) ) {
			$('#emailMsg').hide();
			$('#checkEmail').val(1);
			return false;
		} else {
			$('#emailMsg').hide();
			$('#checkEmail').val('');
			if(secEmail!='')
			checkEmail(secEmail)
		}
	});
	
	/* Swap Secondary email with Primary email */
	$("#swapEmail").click(function() {
		var primaryEmail = $('#primaryEmail').val();
		var newEmail = $('#new_email').val();
		var secondaryEmail = "<?php echo $secEmailVal;?>";
		var newEmailKey = $('#new_email_key').val();
		if(newEmail!=secondaryEmail){
			alert('First update your Secondary email.');
			$('#swapEmail').prop('checked', false);
			runTimeCheckBox();
			return false;
		}
		if(newEmailKey=='verified'){
			if($('#swapEmail').is(':checked') === true) {
				if(secondaryEmail==''){
					alert('Please fill valid Secondary email');
					$('#swapEmail').prop('checked', false);
					runTimeCheckBox();
					return false;
				}else{
					var swapConfirm = confirm('Are you sure you wish to use this email address as your primary and as your login address for the site?');
					if (swapConfirm == true && primaryEmail!='' && secondaryEmail!='') {
						replaceEmails(primaryEmail,secondaryEmail);
					}else{
						$('#swapEmail').prop('checked', false);
						runTimeCheckBox();
					}
				}		
			}
		}else{
			alert('Please verify your secondary email first!');
			$('#swapEmail').prop('checked', false);
			runTimeCheckBox();
			return false;
		}
	});
	
});

/* Function to check email in DB*/
function checkEmail(secEmail){
	
	var BASEPATH = "<?php echo base_url(lang());?>";
	var form_data = {newEmail: secEmail};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/dashboard/checkEmail",
		data: form_data,
		success: function(data)
		{		
			if(data==0){
				$('#emailMsg').show();
				$('#new_email').addClass('error');
				$('#checkEmail').val(1);
				
			}else{
				$('#emailMsg').hide();
				$('#new_email').removeClass('error');
				$('#checkEmail').val('');
			}	
		}
	});
	return false;	
}

/* Function to replace secondary mail with primary */
function replaceEmails(primaryEmail,secondaryEmail)
{   
	var BASEPATH = "<?php echo base_url(lang());?>";
	var BASEUrl = "<?php echo base_url();?>";
	var form_data = {primaryEmail: primaryEmail,secondaryEmail: secondaryEmail};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/dashboard/swapEmail",
		data: form_data,
		success: function(data)
		{	
			if(data==1){
				window.location.href= BASEUrl+'dashboard/globalsettings';
			} else{
				return false;
			}
		}
	});
	return false;	
}

/* Check secondary email after save */
$('#generalSettingForm').submit(function() {
	var checkEmail = $('#checkEmail').val();
	if(checkEmail==1){
		$('#new_email').addClass('error');
		return false;
	}else{
		return true;
	}
});

</script>
