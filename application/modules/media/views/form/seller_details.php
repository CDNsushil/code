<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	
/* Seller settings section */
 $seller_firstName = array(
	'name'=> 'seller_firstName',
	'class'	=> 'font_wN',
	'id'=> 'seller_firstName',	
	'value'	=> $userProfileData->firstName,
	'onclick'=>"placeHoderHideShow(this,'First Name *','hide')",
	'onblur'=>"placeHoderHideShow(this,'First Name *','show')",
	'placeholder'=>"First Name *",
	'disabled' =>'disabled'
 );
 $seller_lastName = array(
	'name'=> 'seller_lastName',	
	'id'=> 'seller_lastName',
	'class'=> 'copy',
	'value'=> $userProfileData->lastName,
	'onclick'=>"placeHoderHideShow(this,'Last Name *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Last Name *','show')",
	'placeholder'=>"Last Name *",
	'disabled' =>'disabled'
 );
 
  $seller_company = array(
	'name'=> 'seller_companyName',
	'id'=> 'seller_companyName',
	'class'	=> 'font_wN',
	'value'	=> set_value('seller_companyName')?set_value('seller_companyName'):$userProfileData->seller_companyName,	
	'onclick'=>"placeHoderHideShow(this,'Company Name ','hide')",
	'onblur'=>"placeHoderHideShow(this,'Company Name','show')",
	'placeholder'=>"Company Name",
	'maxlength'	=> 100,
	'size'	=> 100
);
 
 $seller_address1Input = array(
	'name'=> 'seller_address1',
	'id'=> 'seller_address1',
	'class'	=> 'required font_wN',
	'value'	=> set_value('seller_address1')?set_value('seller_address1'):$userProfileData->seller_address1,	
	'onclick'=>"placeHoderHideShow(this,'Address Line 1 *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Address Line 1 *','show')",
	'placeholder'=>"Address Line 1 *",
	'maxlength'	=> 100,
	'size'	=> 100
);

$seller_address2Input = array(
	'name'	=> 'seller_address2',
	'id'	=> 'seller_address2',
	'class'	=> 'required font_wN',
	'value'	=> set_value('seller_address2')?set_value('seller_address2'):$userProfileData->seller_address2,
	'onclick'=>"placeHoderHideShow(this,'Address Line 2 *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Address Line 2 *','show')",
	'placeholder'=>"Address Line 2 *",
	'maxlength'	=> 100,
	'size'	=> 100
);

$seller_cityInput = array(
	'name'	=> 'seller_city',
	'id'	=> 'seller_city',
	'class'	=> 'required font_wN',
	'value'	=> set_value('seller_city')?set_value('seller_city'):$userProfileData->seller_city,
	'onclick'=>"placeHoderHideShow(this,'Town or City *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Town or City *','show')",
	'placeholder'=>"Town or City *",
	'maxlength'	=> 50,
	'size'	=> 50
);

$seller_zipInput = array(
	'name'=> 'seller_zip',
	'id'=>'seller_zip',
	'class'=> 'number font_wN width_160',
	'value'=> set_value('seller_zip')?set_value('seller_zip'):$userProfileData->seller_zip,
	'onclick'=>"placeHoderHideShow(this,'Post Code or ZIP Code *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Post Code or ZIP Code *','show')",
	'placeholder'=>"Post Code or ZIP Code *",
	'maxlength'	=> 50,
	'size'	=> 50
);
$seller_phoneInput = array(
	'name'=>'seller_phone',
	'id'=>'seller_phone',
	'class'=> 'number  font_wN',
	'value'=> set_value('seller_phone')?set_value('seller_phone'):$userProfileData->seller_phone,
	'onclick'=>"placeHoderHideShow(this,'Phone Number *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Phone Number *','show')",
	'placeholder'=>"Phone Number *",
	'maxlength'=> 50,
	'size'=> 50
);

$seller_emailInput = array(
	'name'=>'seller_email',
	'id'=>'seller_email',
	'class'=> 'font_wN',
	'value'=> set_value('email')?set_value('email'):$userProfileData->email,
	'onclick'=>"placeHoderHideShow(this,'Email *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Email *','show')",
	'placeholder'=>"Email *",
	'maxlength'=> 50,
	'size'=> 50,
);

$sellerCountryValue = ($userProfileData->countryId!='') ? $userProfileData->countryId : 0;
$stateValue = ($userProfileData->seller_state!='') ? $userProfileData->seller_state : 0;

/* End*/
?>
	<ul class=" billing_form form1" >
		<li>
			<?php echo form_input($seller_firstName); ?>
		</li>
		<li>
			<?php echo form_input($seller_lastName); ?>
		</li>
		<li>
			<?php echo form_input($seller_company); ?>
		</li>
		<li>
			<?php echo form_input($seller_address1Input); ?>
		</li>
		<li>
			<?php echo form_input($seller_address2Input); ?>
		</li>
		<li>
			<?php echo form_input($seller_cityInput); ?>
		</li>

		<li class=" width_258 select select_1">
			<?php
			$countries = getCountryList();
			echo form_dropdown('seller_country', $countries, $sellerCountryValue,'id="countriesList"  class=" main_SELECT countriesList selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
			?>
		</li>
		<li class=" width_258 select select_2">
			<?php
			$stateList = (!empty($sellerCountryValue))?getStatesList($sellerCountryValue,true):array(''=>'Select  State, Province or Region');
			echo form_dropdown('seller_state', $stateList, $stateValue,'id="stateList" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
			?>
		</li>
		<li class="width_190">
			<?php echo form_input($seller_zipInput); ?>
		</li>
		<li>
			<?php echo form_input($seller_emailInput); ?>
		</li>
		<li class="mb0">
			<?php echo form_input($seller_phoneInput); ?>
		</li>
	</ul>
