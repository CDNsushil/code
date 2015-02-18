<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$mcd = array(
	'name'=>'mcd',
	'id'=>'mcd'
);
$mce = array(
	'name'=>'mce',
	'id'=>'mce'
);
$mcp = array(
	'name'=>'mcp',
	'id'=>'mcp'
);
$msp = array(
	'name'=>'msp',
	'id'=>'msp'
);

$enterpriseNameInput = array(
	'name'	=> 'enterpriseName',
	'id'	=> 'enterpriseName',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Business Name',
	'onclick'	=> "placeHoderHideShow(this,'Business Name','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Business Name','show')",
	'value'	=> set_value('enterpriseName')?set_value('enterpriseName'):$userProfileData->enterpriseName,
);
$firstNameInput = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class'	=> 'required font_wN',
	'placeholder'	=> 'First Name*',
	'onclick'	=> "placeHoderHideShow(this,'First Name*','hide')",
	'onblur'	=> "placeHoderHideShow(this,'First Name*','show')",
	'value'	=> set_value('firstName')?set_value('firstName'):$userProfileData->firstName,
);
$lastNameInput = array(
	'name'	=> 'lastName',
	'id'	=> 'lastName',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Last Name',
	'onclick'	=> "placeHoderHideShow(this,'Last Name','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Last Name','show')",
	'value'	=> set_value('lastName')?set_value('lastName'):$userProfileData->lastName,
);

$emailInput = array(
	'type'	=> 'email',
	'notEqualTo'	=> '#userEmail',
	'name'	=> 'email',
	'id'	=> 'email',
	'class'	=> 'required email font_wN',
	'placeholder'	=> 'New Email Adress*',
	'onclick'	=> "placeHoderHideShow(this,'New Email Adress*','hide')",
	'onblur'	=> "placeHoderHideShow(this,'New Email Adress*','show')",
	'value'	=> '',
);


$confirmEmailInput = array(
	'type'	=> 'email',
	'equalto'	=> '#email',
	'name'	=> 'confirmEmail',
	'id'	=> 'confirmEmail',
	'class'	=> 'required email font_wN',
	'placeholder'	=> 'Confirm Email Adress*',
	'onclick'	=> "placeHoderHideShow(this,'Confirm Email Adress*','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Confirm Email Adress*','show')",
	'value'	=> '',
);

$passwordInput = array(
	'type'	=> 'password',
	'name'	=> 'password',
	'id'	=> 'password',
	'class'	=> 'required font_wN',
	'value'	=> '',
	'placeholder'	=> 'New Password*',
	'onclick'	=> "placeHoderHideShow(this,'New Password*','hide')",
	'onblur'	=> "placeHoderHideShow(this,'New Password*','show')",
	'minlength'	=> 8,
	'maxlength'	=> 50
);
$confirmPasswordInput = array(
	'type'	=> 'password',
	'equalto'	=> '#password',
	'name'	=> 'confirmPassword',
	'id'	=> 'confirmPassword',
	'class'	=> 'required font_wN',
	'placeholder'	=> 'Confirm Password*',
	'onclick'	=> "placeHoderHideShow(this,'Confirm Password*','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Confirm Password*','show')",
	'value'	=> '',
	'minlength'	=> 8,
	'maxlength'	=> 50
);

$generalSettingsInput = array(
	'name'	=> 'generalSettings',
	'type'	=> 'hidden',
	'id'	=> 'generalSettings',
	'value'	=>'generalSettings'
);

// set enterprise type 
$isEnterprise = LoginUserDetails('enterprise');
?> 
<div class="TabbedPanelsContentGroup main_tab m_auto ">

	<!--========================== Membership Settings==============================-->

	<div class="TabbedPanelsContent TabbedPanelsContentVisible">
		<div id="TabbedPanels3" class="TabbedPanels tab_setting">

		<!--========================== stage 2 :- second tab  ==============================-->

			<ul class="TabbedPanelsTabGroup scond_li">
				<li class="TabbedPanelsTab msSabMenu TabbedPanelsTabSelected" id="msMenu" onclick="hideShow(this,'#ms','.msContents','slow','.msSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)" ><span>Membership Settings</span></a></li>
				<li class="TabbedPanelsTab msSabMenu"  id="spMenu" onclick="hideShow(this,'#sp','.msContents','slow','.msSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)"><span>Search Preferences</span></a></li>
				<li class="TabbedPanelsTab msSabMenu" id="daMenu" onclick="hideShow(this,'#da','.msContents','slow','.msSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)"><span>Delete your Account</span></a></li>
			</ul>

			<div id="ms" class="TabbedPanelsContentGroup msContents">
			<!--========================== stage 2 :- content  ==============================--> 

			<!-- =================Membership Settings==================-->

				<div class="TabbedPanelsContent  TabbedPanelsContentVisible">
					<h3 class="red fs21 fnt_mouse  bb_aeaeae">Contact Details</h3>
					<?php echo form_open($this->uri->uri_string(),$mcd); ?>
					<ul class="mt25 billing_form form2">
						<li>
						<?php echo form_input($firstNameInput); ?>
						</li>
						<li>
						<?php echo form_input($lastNameInput); ?>
						</li>
                        <?php if($isEnterprise == 't') { ?>
                            <li>
                                <?php echo form_input($enterpriseNameInput); ?>
                            </li>
                        <?php } ?>
						<li class=" width_258  mr200 select select_1">
						
						<?php
							$countryId=$userProfileData->countryId;
							$countryId=set_value('countryId')?set_value('countryId'):$countryId;
							echo form_dropdown('countryId', $countryList, $countryId,'id="countryId" class="main_SELECT countriesList" onchange="getStateList(\'stateList\',this.value,\'stateId\',\'main_SELECT\');"');
					  ?>
						</li>
						<li class=" width_258 fl select select_2 stateListDiv" id="stateList" >
								<?php    
								$stateList = getStatesList($countryId,true); 
								$stateId=$userProfileData->stateId;
								$stateId=set_value('stateId')?set_value('stateId'):$stateId;
								echo form_dropdown('stateId', $stateList, $stateId,'class="main_SELECT"');
								?>
						</li>
						<li class="fr mt-10">
						<button class="red fr p10 bdr_a0a0a0 fshel_bold width_88" type="submit">Save</button>
						</li>
					</ul>
					<?php echo form_close(); ?>
						
					<div class="clearb"></div>
					<h3 class="red fs21 fnt_mouse  bb_aeaeae">Registered Email Address</h3>
					<ul class="mt20 billing_form form2">
						<li class="gs_email_text">
							<?php echo $userProfileData->email;?>
						</li>
					</ul>
						
					<div class="clearb"></div>
					<h3 class="red fs21 fnt_mouse  bb_aeaeae">Change Email</h3>
					
					<?php echo form_open($this->uri->uri_string(),$mce); ?>
					<ul class="mt25 billing_form form2">
					<li class="width_258">
						<?php echo form_input($emailInput); ?>
					</li>
					<li class="width_258">
						<?php echo form_input($confirmEmailInput); ?>
					</li>
					<li class="icon_2 fl mt12 bdr_non">Remember you will need to use this email address when you next login.</li>
					<li class="fr">
					<button class="red fr p10 bdr_a0a0a0 fshel_bold width_auto" type="submit">Change Email</button>
					</li>
					</ul>
					<?php echo form_close(); ?>
					<div class="clearb"></div>
					<h3 class="red fs21 fnt_mouse  bb_aeaeae">Change Password</h3>
					
					<?php echo form_open($this->uri->uri_string(),$mcp); ?>
					<ul class="mt25 billing_form form2 mb25 fl">
					<li>
					<?php echo form_input($passwordInput); ?>
					</li>
					<li>
					<?php echo form_input($confirmPasswordInput); ?>
					</li>
					<li class="fr">
					<button class="red fr p10 bdr_a0a0a0 fshel_bold width_auto" type="submit">Change Password</button>
					</li>
					</ul>
					<?php echo form_close(); ?>
					
				</div>
			</div>
		
			<div id="sp" class="TabbedPanelsContentGroup  msContents dn ">
				 <!--========================== stage 2 :- content  ==============================--> 
				 <div class="TabbedPanelsContent width635 TabbedPanelsContentVisible">
						<h3 class="red fs21 fnt_mouse  bb_aeaeae">Search Preferences</h3>
						<h4 class="fs18">Set your default preferences for all your searches on Toadsquare</h4>
						<?php echo form_open($this->uri->uri_string(),$msp); ?>
							<ul class="mt25 billing_form form2">
								 <li class=" width_258 select one_select ">
									 <?php
											$language = getlanguageList();
											$firstLanguage=$userProfileData->firstLanguage;
											$firstLanguage=set_value('firstLanguage')?set_value('firstLanguage'):$firstLanguage;
											echo form_dropdown('firstLanguage', $language, $firstLanguage,'id="firstLanguage" class="main_SELECT"');
										?>
						 
										
								 </li>
								 <li class="width_258 select two_select">
										<?php
											$secondLanguage=$userProfileData->secondLanguage;
											$firstLanguage=set_value('secondLanguage')?set_value('secondLanguage'):$secondLanguage;
											echo form_dropdown('secondLanguage', $language, $secondLanguage,'id="secondLanguage" class="main_SELECT"');
										 ?>
								 </li>
								 <li class="width_258 select three_select">
										<?php
											$firstCountryId=$userProfileData->firstCountryId;
											$firstCountryId=set_value('firstCountryId')?set_value('firstCountryId'):$firstCountryId;
											echo form_dropdown('firstCountryId', $countryList, $firstCountryId,'id="firstCountryId" class="main_SELECT"');
										?>
								 </li>
								 <li class=" width_258  select four_select ">
										<?php
											$secondCountryId=$userProfileData->secondCountryId;
											$secondCountryId=set_value('secondCountryId')?set_value('secondCountryId'):$secondCountryId;
											echo form_dropdown('secondCountryId', $countryList, $secondCountryId,'id="secondCountryId" class="main_SELECT"');
										?>
								 </li>
							</ul>
							<h3 class="fs21 bb_aeaeae">Content Filter</h3>
              <h4 class="fs18">Toadsquare members classify their content when they upload it. If you prefer NOT to see any of the following, select them and we will modify your search results.</h4>
							<ul class="mt25 glob_list defaultP">
								 <li>
										<label>
											 <?php 
												$suitableForGeneralAudiences=$userProfileData->suitableForGeneralAudiences;
												$suitableForGeneralAudiences=set_value('suitableForGeneralAudiences')?set_value('suitableForGeneralAudiences'):$suitableForGeneralAudiences;
												$checked=($suitableForGeneralAudiences=='t')?'checked':'';
												echo '<input type="checkbox" '.$checked.' value="t" id="suitableForGeneralAudiences" name="suitableForGeneralAudiences" />';
												echo $this->lang->line('suitableForGeneralAudiences');?>
										</label>
								 </li>
								 <li>
										<label>
										<?php 
											$suitableForChildren=$userProfileData->suitableForChildren;
											$suitableForChildren=set_value('suitableForChildren')?set_value('suitableForChildren'):$suitableForChildren;
											$checked=($suitableForChildren=='t')?'checked':'';
											echo '<input type="checkbox" '.$checked.' value="t" id="suitableForChildren" name="suitableForChildren" />';
											echo $this->lang->line('suitableForChildren');?>
										</label>
								 </li>
								 <li>
										<label>
											<?php 
									$suitableForYoungAdults=$userProfileData->suitableForYoungAdults;
									$suitableForYoungAdults=set_value('suitableForYoungAdults')?set_value('suitableForYoungAdults'):$suitableForYoungAdults;
									$checked=($suitableForYoungAdults=='t')?'checked':'';
									echo '<input type="checkbox" '.$checked.' value="t" id="suitableForYoungAdults" name="suitableForYoungAdults" />';
									echo $this->lang->line('suitableForYoungAdults');
								?>
										</label>
								 </li>
								 <li>
										<label>
										<?php 
									$someContentCouldBeOfens=$userProfileData->someContentCouldBeOfens;
									$someContentCouldBeOfens=set_value('someContentCouldBeOfens')?set_value('someContentCouldBeOfens'):$someContentCouldBeOfens;
									$checked=($someContentCouldBeOfens=='t')?'checked':'';
									echo '<input type="checkbox" '.$checked.' value="t" id="someContentCouldBeOfens" name="someContentCouldBeOfens" />';
									echo $this->lang->line('someContentCouldBeOfensive');
								?>
										</label>
								 </li>
								 <li class="pl30 red">
										<b>Adults Only Material is NOT Allowed.</b></li>
								 <li class="fr mt30">
										<button class="red fr p10 bdr_a0a0a0 fshel_bold width_auto" type="submit">Save</button>
								 </li>
								 <li class="icon_2 fl mt12 bdr_non">Use our <a href="" class="clr_444">Search</a> to find content you’re interested in.</li>
							</ul>
						<?php echo form_close(); ?>
				 </div>
			</div>
										 
			<div id="da" class="TabbedPanelsContentGroup dn">
				 <!-- =================Delet Account=================-->
				 <div class="TabbedPanelsContent width635 TabbedPanelsContentVisible">
						<h3 class="red fs21 fnt_mouse  bb_aeaeae">Delete your Account</h3>
            <h4 class="fs18">If you have an ongoing sale, your account cannot be deleted until it is complete. Details of your sales can be found from Your Toadsquare menu in Your Shopping Cart > Sales.</h4>
                                        
						<div class="fr mt30 mb30">
							<?php $deleteAccount_popup=$this->load->view("deleteAccount_popup",'',true); ?>
								<script>
									var deleteAccount_popup=<?php echo json_encode($deleteAccount_popup);?>;
								</script>
							 <input class="red fr p10 bdr_a0a0a0 fshel_bold width_auto" type="button" value="Delete Account" role="button" onclick="loadPopupData('popupBoxWp','popup_box',deleteAccount_popup);"  />
						</div>
				 </div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$("#mcd").validate({
		 submitHandler: function() {
			var fromData=$("#mcd").serialize(); 
			$.post(baseUrl+language+'/dashboard/saveContactDetails',fromData, function(data) {
				if(data && data.msg){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
			  }
			}, "json");
		 }
	});
	$("#mce").validate({
		 submitHandler: function() {
			var fromData=$("#mce").serialize(); 
			$.post(baseUrl+language+'/dashboard/saveEmail',fromData, function(data) {
				if(data && data.msg){
						$('#userEmail').val(data.email);
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
			  }
			}, "json");
		 }
	});
	$("#mcp").validate({
		 submitHandler: function() {
			var fromData=$("#mcp").serialize(); 
			$.post(baseUrl+language+'/dashboard/savePassword',fromData, function(data) {
				if(data && data.msg){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
			  }
			}, "json");
		 }
	});
	$("#msp").validate({
		 submitHandler: function() {
			var fromData=$("#msp").serialize(); 
			$.post(baseUrl+language+'/dashboard/saveSearchPreferences',fromData, function(data) {
				if(data && data.msg){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
			  }
			}, "json");
		 }
	});
});
</script>
