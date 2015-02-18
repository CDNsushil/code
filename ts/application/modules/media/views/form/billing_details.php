<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	

$firstNameValue       =   (!empty($userProfileData->billing_firstName))?$userProfileData->billing_firstName:"";
$lastNameValue        =   (!empty($userProfileData->billing_lastName))?$userProfileData->billing_lastName:"";
$companyNameValue     =   (!empty($userProfileData->billing_companyName))?$userProfileData->billing_companyName:"";
$addressLine1Value    =   (!empty($userProfileData->billing_address1))?$userProfileData->billing_address1:"";
$addressLine2Value    =   (!empty($userProfileData->billing_address2))?$userProfileData->billing_address2:"";
$townOrCityValue      =   (!empty($userProfileData->billing_city))?$userProfileData->billing_city:"";
$stateValue           =   (!empty($userProfileData->billing_state))?$userProfileData->billing_state:"";
$countryValue         =   (!empty($userProfileData->billing_country))?$userProfileData->billing_country:"";
$zipCodeValue         =   (!empty($userProfileData->billing_zip))?$userProfileData->billing_zip:"";
$phoneNumberValue     =   (!empty($userProfileData->billing_phone))?$userProfileData->billing_phone:"";
$emailValue           =   (!empty($userProfileData->billing_email))?$userProfileData->billing_email:"";

$firstName          =   array(
  'name'            =>  'firstName',
  'id'              =>  'firstName',
  'class'           =>  'font_wN required',
  'title'           =>  $this->lang->line('packpayment_required_field'),
  'value'           =>  $firstNameValue,
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'First name*','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'First name*','show')",
  'placeholder'     =>  "First name*",
);

$lastName           =   array(
  'name'            =>  'lastName',
  'id'              =>  'lastName',
  'class'           =>  'font_wN required',
  'title'           =>  $this->lang->line('packpayment_required_field'),
  'value'           =>  $lastNameValue,
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Last name','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Last name','show')",
  'placeholder'     => "Last name",
);

$companyName        =   array(
  'name'            =>  'companyName',
  'id'              =>  'companyName',
  'class'           =>  'font_wN',
  'value'           =>  $companyNameValue,
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Company Name','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Company Name','show')",
  'placeholder'     =>  "Company Name",
);

$addressLine1       =   array(
  'name'            =>  'addressLine1',
  'id'              =>  'addressLine1',
  'class'           =>  'font_wN required',
  'title'           =>  $this->lang->line('packpayment_required_field'),
  'value'           =>  $addressLine1Value,
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Address Line 1*','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Address Line 1*','show')",
  'placeholder'     =>  "Address Line 1*",
);

$addressLine2       =   array(
  'name'            =>  'addressLine2',
  'id'              =>  'addressLine2',
  'class'           =>  'font_wN',
  'value'           =>  $addressLine2Value,
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Address Line 2','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Address Line 2','show')",
  'placeholder'     =>  "Address Line 2",
);

$townOrCity         =   array(
  'name'            =>  'townOrCity',
  'id'              =>  'townOrCity',
  'class'           =>  'font_wN required',
  'title'           =>  $this->lang->line('packpayment_required_field'),
  'value'           =>  $townOrCityValue,
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Town or City','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Town or City','show')",
  'placeholder'     =>  "Town or City",
);

$zipCode  =   array(
  'name'            =>  'zipCode',
  'id'              =>  'zipCode',
  'class'           =>  'font_wN width_160 required',
  'title'           =>  $this->lang->line('packpayment_required_field'),
  'value'           =>  $zipCodeValue,
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Post Code or ZIP Code','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Post Code or ZIP Code','show')",
  'placeholder'     =>  "Post Code or ZIP Code",
);

$email              =   array(
  'name'            =>  'email',
  'id'              =>  'email',
  'class'           =>  'font_wN required email',
  'title'           =>  $this->lang->line('packpayment_required_field'),
  'value'           =>  $emailValue,
  'maxlength'	      =>  80,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Email Address*','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Email Address*','show')",
  'placeholder'     => "Email Address*",
);


$phoneNumber        =   array(
  'name'            =>  'phoneNumber',
  'id'              =>  'phoneNumber',
  'class'           =>  'font_wN',
  'value'           =>  $phoneNumberValue,
  'minlength'       =>  2,
  'maxlength'       =>  25,
  'size'            =>  30,
  'onclick'         =>  "placeHoderHideShow(this,'Phone Number','hide')",
  'onblur'          =>  "placeHoderHideShow(this,'Phone Number','show')",
  'placeholder'     =>  "Phone Number",
);

$otherAboutConsumptionTaxInput = array(
	'name'	=> 'otherAboutConsumptionTax',
	'id'	=> 'otherAboutConsumptionTax',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Tax / Business Registration Number: e.g. EU VAT Number',
	'onclick'	=> "placeHoderHideShow(this,'Tax / Business Registration Number: e.g. EU VAT Number','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Tax / Business Registration Number: e.g. EU VAT Number','show')",
	'value'	=> set_value('otherAboutConsumptionTax')?set_value('otherAboutConsumptionTax'):$userProfileData->otherAboutConsumptionTax,
);
// set base url
$baseUrl = formBaseUrl();
$addSpaceProjectId = $this->session->userdata('addSpaceProjectId');
?>
<!--
	<ul class="TabbedPanelsTabGroup second_ul pt20 pb20">
		<li class="TabbedPanelsTab" ><a href="<?php echo $baseUrl;?>"><span><?php echo $this->lang->line('showcaseStep1');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="<?php echo $baseUrl.'/membershipcart';?>"><span><?php echo $this->lang->line('showcaseStep2');?></span></a></li>
		<li class="TabbedPanelsTab TabbedPanelsTabSelected" ><a href="<?php echo $baseUrl.'/billingdetails';?>"><span><?php echo $this->lang->line('showcaseStep3');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep4');?></span></a></li>
		<li class="TabbedPanelsTab " >  <a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep5');?></span> </a></li>
	</ul>
-->
	<div class="TabbedPanelsContentGroup width635 m_auto "> 
		<!--==========================     Step 3 Billing Information ==============================-->
		<?php echo form_open($baseUrl.'/billingdetailspost/',$mce); ?>
			<div class="TabbedPanelsContent">
				<div class="wra_head clearb">
					<h3 class="red   fs21 bb_aeaeae"> <?php echo $this->lang->line('billingDetails');?> </h3>
					<div class="sap_30"></div>
					<div class=" display_inline_block defaultP">
						<label class="mr15">
							<input  type="checkbox" name="isSameAsSeller" id="isSameAsSeller" value="1" />
							<?php echo $this->lang->line('sameAsSeller');?>
						</label>

					</div>
					<div class="sap_30"></div>
					<!-- billing details -->
					<div id="billingDetails">
						<ul class="billing_form form1" >
							<li>
							   <?php echo form_input($firstName); ?>
							</li>
							<li>
								<?php echo form_input($lastName); ?>
							</li>
							<li>
								<?php echo form_input($companyName); ?>
							</li>
							<li>
								<?php echo form_input($addressLine1); ?>
							</li>
							<li>
								<?php echo form_input($addressLine2); ?>
							</li>
							<li>
								<?php echo form_input($townOrCity); ?>
							</li>
							<li class=" width_258 select select_1">
								<?php
								$countries = getCountryList();
								
								echo form_dropdown('countriesList', $countries, $countryValue,'id="countriesList" class=" main_SELECT countriesList selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
								?>
							</li>
							<li class=" width_258 select select_2 stateListDiv">
								<?php
								$stateList = (!empty($countryValue))?getStatesList($countryValue,true):array(''=>'Select  State, Province or Region');
								echo form_dropdown('stateList', $stateList, $stateValue,'id="stateList" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
								?>
							</li>
							<li class="width_190">
								<?php echo form_input($zipCode); ?>
							</li>
							<li>
								<?php echo form_input($email); ?>
							</li>
							<li>
								<?php echo form_input($phoneNumber); ?>
							</li>
							
						</ul>
					</div>
					
					<!-- seller details -->
					<div id="sellerDetails" class="dn">
						<?php $this->load->view('form/seller_details');?>
					</div>	
					
					<!-- global setting checkbox  -->
					<ul class="billing_form form1">
						<li class="bdr_non mt25">
							<label class="pl5 fshel_midum defaultP lineH20 fl">
								<input class="ez-hide width_auto" type="checkbox" value="1" name="isSaveInBilling" />
								<?php echo $this->lang->line('saveInBilling');?>  
								<a href="<?php echo base_url(lang().'/dashboard/globalsettings');?>"><?php echo $this->lang->line('globalSetting');?></a>
							</label>
						</li>
					</ul>
					
					<!-- tax input box  -->
					<h4 class="red fs21 bb_aeaeae"> <?php echo $this->lang->line('taxInfo');?> </h4>
					<div class="sap_40"></div>
					<ul class=" billing_form">
						<li class="bdr_non mb0"><?php echo $this->lang->line('enterTax');?> </li>
						<li>
							<?php echo form_input($otherAboutConsumptionTaxInput); ?>
						</li>
					</ul>
					
					<!-- form buttons  -->
                    <?php
                    $data['backUrl'] = $baseUrl.'/membershipcart';
                    if(!empty($addSpaceProjectId)) {
                        $data['backUrl'] = $baseUrl.'/membershipcart/'.$addSpaceProjectId;
                    }
                    $this->load->view('common_view/common_buttons',$data);
                    ?>
				</div>
			</div>
		<?php echo form_close();?>
	</div>
	
	<script type="text/javascript">
		$('#isSameAsSeller').click(function() {
			if($('#isSameAsSeller').is(':checked')) {
				$('#billingDetails').hide();
				$('#sellerDetails').show();
			} else {
				$('#billingDetails').show();
				$('#sellerDetails').hide();
			}
		});
	</script>
	
				
        
