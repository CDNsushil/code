<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$lang=lang();
$billingForm = array(
	'name'=>'billingForm',
	'id'=>'billingForm'
);
$shippingForm = array(
	'name'=>'shippingForm',
	'id'=>'shippingForm'
);

$billing_firstNameInput = array(
	'name'	=> 'billing_firstName',
	'id'	=> 'billing_firstName',
	'class'	=> 'required font_wN',
	'placeholder'	=> 'First Name*',
	'onclick'	=> "placeHoderHideShow(this,'First Name','hide')",
	'onblur'	=> "placeHoderHideShow(this,'First Name','show')",
	'value'	=> set_value('billing_firstName')?set_value('billing_firstName'):$userProfileData->billing_firstName,
);
$billing_lastNameInput = array(
	'name'	=> 'billing_lastName',
	'id'	=> 'billing_lastName',
	'class'	=> 'required font_wN',
	'placeholder'	=> 'Last Name*',
	'onclick'	=> "placeHoderHideShow(this,'Last Name','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Last Name','show')",
	'value'	=> set_value('billing_lastName')?set_value('billing_lastName'):$userProfileData->billing_lastName,
);
$billing_companyNameInput = array(
	'name'	=> 'billing_companyName',
	'id'	=> 'billing_companyName',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Company Name',
	'onclick'	=> "placeHoderHideShow(this,'Company Name','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Company Name','show')",
	'value'	=> set_value('billing_companyName')?set_value('billing_companyName'):$userProfileData->billing_companyName
);
$billing_cityInput = array(
	'name'	=> 'billing_city',
	'id'	=> 'billing_city',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Town or City',
	'onclick'	=> "placeHoderHideShow(this,'Town or City','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Town or City','show')",
	'value'	=> set_value('billing_city')?set_value('billing_city'):$userProfileData->billing_city,
);
$billing_address1Input = array(
	'name'	=> 'billing_address1',
	'id'	=> 'billing_address1',
	'class'	=> 'font_wN required',
	'placeholder'	=> 'Address Line 1 *',
	'onclick'	=> "placeHoderHideShow(this,'Address Line 1','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Address Line 1','show')",
	'value'	=> set_value('billing_address1')?set_value('billing_address1'):$userProfileData->billing_address1,
);
$billing_address2Input = array(
	'name'	=> 'billing_address2',
	'id'	=> 'billing_address2',
	'class'	=> 'font_wN required',
	'placeholder'	=> 'Address Line 2 *',
	'onclick'	=> "placeHoderHideShow(this,'Address Line 2','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Address Line 2','show')",
	'value'	=> set_value('billing_address2')?set_value('billing_address2'):$userProfileData->billing_address2,
	'maxlength'	=> 100,
	'size'	=> 100
);

$billing_zipInput = array(
	'name'	=> 'billing_zip',
	'id'	=> 'billing_zip',
	'class'	=> 'font_wN width_160',
	'placeholder'	=> 'Post Code or ZIP Code',
	'onclick'	=> "placeHoderHideShow(this,'Post Code or ZIP Code','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Post Code or ZIP Code','show')",
	'value'	=> set_value('billing_zip')?set_value('billing_zip'):$userProfileData->billing_zip,
);
$billing_phoneInput = array(
	'name'	=> 'billing_phone',
	'id'	=> 'billing_phone',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Phone Number',
	'onclick'	=> "placeHoderHideShow(this,'Phone Number','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Phone Number','show')",
	'value'	=> set_value('billing_phone')?set_value('billing_phone'):$userProfileData->billing_phone,
);
$billing_emailInput = array(
	'name'	=> 'billing_email',
	'id'	=> 'billing_email',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Email Address',
	'onclick'	=> "placeHoderHideShow(this,'Email Address','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Email Address','show')",
	'value'	=> set_value('billing_email')?set_value('billing_email'):$userProfileData->billing_email,
);

$shipping_firstNameInput = array(
	'name'	=> 'shipping_firstName',
	'id'	=> 'shipping_firstName',
	'class'	=> 'required font_wN',
	'placeholder'	=> 'First Name*',
	'onclick'	=> "placeHoderHideShow(this,'First Name','hide')",
	'onblur'	=> "placeHoderHideShow(this,'First Name','show')",
	'value'	=> set_value('shipping_firstName')?set_value('shipping_firstName'):$userProfileData->shipping_firstName,
);
$shipping_lastNameInput = array(
	'name'	=> 'shipping_lastName',
	'id'	=> 'shipping_lastName',
	'class'	=> 'required font_wN',
	'placeholder'	=> 'Last Name*',
	'onclick'	=> "placeHoderHideShow(this,'Last Name','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Last Name','show')",
	'value'	=> set_value('shipping_lastName')?set_value('shipping_lastName'):$userProfileData->shipping_lastName,
);

$shipping_companyNameInput = array(
	'name'	=> 'shipping_companyName',
	'id'	=> 'shipping_companyName',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Company Name',
	'onclick'	=> "placeHoderHideShow(this,'Company Name','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Company Name','show')",
	'value'	=> set_value('shipping_companyName')?set_value('shipping_companyName'):$userProfileData->shipping_companyName
);

$shipping_cityInput = array(
	'name'	=> 'shipping_city',
	'id'	=> 'shipping_city',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Town or City',
	'onclick'	=> "placeHoderHideShow(this,'Town or City','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Town or City','show')",
	'value'	=> set_value('shipping_city')?set_value('shipping_city'):$userProfileData->shipping_city,
);
$shipping_address1Input = array(
	'name'	=> 'shipping_address1',
	'id'	=> 'shipping_address1',
	'class'	=> 'font_wN required',
	'placeholder'	=> 'Address Line 1 *',
	'onclick'	=> "placeHoderHideShow(this,'Address Line 1','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Address Line 1','show')",
	'value'	=> set_value('shipping_address1')?set_value('shipping_address1'):$userProfileData->shipping_address1,
);
$shipping_address2Input = array(
	'name'	=> 'shipping_address2',
	'id'	=> 'shipping_address2',
	'class'	=> 'font_wN required',
	'placeholder'	=> 'Address Line 2 *',
	'onclick'	=> "placeHoderHideShow(this,'Address Line 2','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Address Line 2','show')",
	'value'	=> set_value('shipping_address2')?set_value('shipping_address2'):$userProfileData->shipping_address2,
);

$shipping_zipInput = array(
	'name'	=> 'shipping_zip',
	'id'	=> 'shipping_zip',
	'class'	=> 'font_wN width_160',
	'placeholder'	=> 'Post Code or ZIP Code',
	'onclick'	=> "placeHoderHideShow(this,'Post Code or ZIP Code','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Post Code or ZIP Code','show')",
	'value'	=> set_value('shipping_zip')?set_value('shipping_zip'):$userProfileData->shipping_zip,
);
$shipping_phoneInput = array(
	'name'	=> 'shipping_phone',
	'id'	=> 'shipping_phone',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Phone Number',
	'onclick'	=> "placeHoderHideShow(this,'Phone Number','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Phone Number','show')",
	'value'	=> set_value('shipping_phone')?set_value('shipping_phone'):$userProfileData->shipping_phone,
	'maxlength'	=> 50,
	'size'	=> 50
);
$shipping_emailInput = array(
	'name'	=> 'shipping_email',
	'id'	=> 'shipping_email',
	'class'	=> 'font_wN',
	'placeholder'	=> 'Email Address',
	'onclick'	=> "placeHoderHideShow(this,'Email Address','hide')",
	'onblur'	=> "placeHoderHideShow(this,'Email Address','show')",
	'value'	=> set_value('shipping_email')?set_value('shipping_email'):$userProfileData->shipping_email,
);

$EuVatIdentificationNumberInput = array(
	'name'	=> 'EuVatIdentificationNumber',
	'id'	=> 'EuVatIdentificationNumber',
	'class'	=> 'font_wN',
	'placeholder'	=> 'EU VAT Number',
	'onclick'	=> "placeHoderHideShow(this,'EU VAT Number','hide')",
	'onblur'	=> "placeHoderHideShow(this,'EU VAT Number','show')",
	'value'	=> set_value('EuVatIdentificationNumber')?set_value('EuVatIdentificationNumber'):$userProfileData->EuVatIdentificationNumber,
	'maxlength'	=> 50,
	'size'	=> 50
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

?>
<div class="TabbedPanelsContentGroup main_tab m_auto "> 
            
	<!--========================== Membership Settings==============================-->

	<div class="TabbedPanelsContent TabbedPanelsContentVisible">
			<div id="TabbedPanels4" class="TabbedPanels tab_setting"> 
			<!--========================== stage 2 :- second tab  ==============================-->
			
			<ul class="TabbedPanelsTabGroup scond_li">
				<li class="TabbedPanelsTab bsSabMenu TabbedPanelsTabSelected" id="bdMenu" onclick="hideShow(this,'#bd','.bsContents','slow','.bsSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)" ><span>Billing Details</span></a></li>
				<li class="TabbedPanelsTab bsSabMenu " id="sdMenu"  onclick="hideShow(this,'#sd','.bsContents','slow','.bsSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)" ><span>Shipping Details</span></a></li>
			</ul>
			<div class="TabbedPanelsContentGroup bsContents" id="bd"> 
				<div class="TabbedPanelsContent TabbedPanelsContentVisible">
					<div class="wra_head clearb">
						<h3 class="red   fs21 fnt_mouse bb_aeaeae"> Billing Details </h3>
						<div class="sap_30"></div>
								<?php echo form_open($this->uri->uri_string(),$billingForm); ?>	
									<div class=" display_inline_block defaultP">
							
										<?php
										$seller_address1 = (isset($userProfileData->seller_address1) && !empty($userProfileData->seller_address1))?$userProfileData->seller_address1:false;
										$seller_address2 = (isset($userProfileData->seller_address2) && !empty($userProfileData->seller_address1))?$userProfileData->seller_address2:false;
										if($seller_address1 || $seller_address2){
												?>
												<label>
													<input type="checkbox" <?php if($userProfileData->billing_isSameAsSeller=='t'){ echo 'checked'; }?> value="t" id="billing_isSameAsSeller" name="billing_isSameAsSeller" onclick="if(this.checked){copyFromSeller('billing')};" />
														Same as Seller Details
												</label>
											 <?php
										}?>
										
								</div>
							<div class="sap_30"></div>
								
						<ul class=" billing_form form1" >
							<li><?php echo form_input($billing_firstNameInput); ?></li>
							<li><?php echo form_input($billing_lastNameInput); ?></li>
							<li><?php echo form_input($billing_companyNameInput); ?></li>
							<li><?php echo form_input($billing_address1Input); ?></li>
							<li><?php echo form_input($billing_address2Input); ?></li>
							<li><?php echo form_input($billing_cityInput); ?></li>
							<li class=" width_258 select select_1">
									<?php
										$billing_country=$userProfileData->billing_country;
										$billing_country=set_value('billing_country')?set_value('billing_country'):$billing_country;
										echo form_dropdown('billing_country', $countryList, $billing_country,'id="billing_country" class="main_SELECT" onchange="getStateList(\'billingState\',this.value,\'billing_state\',\'main_SELECT\');"');
									?>
							</li>
							<li class=" width_258 select select_2" id="billingState">
								<?php    
										$stateList = getStatesList($billing_country,true); 
										$billing_state=$userProfileData->billing_state;
										$billing_state=set_value('billing_state')?set_value('billing_state'):$billing_state;
										echo form_dropdown('billing_state', $stateList, $billing_state,'class="main_SELECT"');
								?>
							</li>
							<li class="width_190"><?php echo form_input($billing_zipInput); ?></li>
							<li><?php echo form_input($billing_emailInput); ?></li>
							<li><?php echo form_input($billing_phoneInput); ?></li>
						</ul>
						<h4 class="red fs21 mt52 bb_aeaeae"> Tax / Business Information </h4>
                            <div class="sap_40"></div>
                            <ul class=" billing_form">
                        <li class="bdr_non mb0">Enter a tax or business registration number if you need it to appear on your sales records.</li>
                        <li><?php echo form_input($otherAboutConsumptionTaxInput); ?></li>
                      </ul>
									<div class="fr btn_wrap display_block font_weight">
										<button class="red fr p10 bdr_a0a0a0 fshel_bold" type="button" onclick="$('#billingForm').submit();" >Save</button>
									</div>
								<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="TabbedPanelsContentGroup bsContents dn" id="sd"> 
				 <div class="TabbedPanelsContent TabbedPanelsContentVisible">
						<div class="wra_head clearb">
							 <h3 class="red   fs21 fnt_mouse bb_aeaeae"> Shipping Details </h3>
							 <div class="sap_30"></div>
							 <?php echo form_open($this->uri->uri_string(),$shippingForm); ?>
								 <div class=" display_inline_block defaultP">
										<?php
										$billing_address1 = (isset($userProfileData->billing_address1) && !empty($userProfileData->billing_address1))?$userProfileData->billing_address1:false;
										$billing_address2 = (isset($userProfileData->billing_address2) && !empty($userProfileData->billing_address2))?$userProfileData->billing_address2:false;
										if($seller_address1 || $seller_address2){ ?>
											<label class="pr10">
												<input type="checkbox" <?php if($userProfileData->shipping_isSameAsSeller=='t'){ echo 'checked'; }?> value="t" id="shipping_isSameAsSeller" name="shipping_isSameAsSeller"  onclick="if(this.checked){copyFromSeller('shipping'); $('#shipping_isSameAsBilling').attr('checked',false); runTimeCheckBox();}; ">
												Same as Seller Details
											</label>
											<?php
										}
										if($billing_address1 || $billing_address1 ){ ?>
											<label>
												<input type="checkbox" <?php if($userProfileData->shipping_isSameAsBilling=='t'){ echo 'checked'; }?> value="t" id="shipping_isSameAsBilling" name="shipping_isSameAsBilling"  onclick="if(this.checked){copyFromBilling('shipping'); $('#shipping_isSameAsSeller').attr('checked',false); runTimeCheckBox();};">
												Same as Buyer Details
											</label>
											<?php
										}
										?>
								 </div>
								 <div class="sap_30"></div>
							 
								 <ul class=" billing_form form1" >
										<li><?php echo form_input($shipping_firstNameInput); ?></li>
										<li><?php echo form_input($shipping_lastNameInput); ?></li>
										<li><?php echo form_input($shipping_companyNameInput); ?></li>
										<li><?php echo form_input($shipping_address1Input); ?></li>
										<li><?php echo form_input($shipping_address2Input); ?></li>
										<li><?php echo form_input($shipping_cityInput); ?></li>
										<li class=" width_258 select select_1">
											 <?php
													$shipping_country=$userProfileData->shipping_country;
													$shipping_country=set_value('shipping_country')?set_value('shipping_country'):$shipping_country;
													echo form_dropdown('shipping_country', $countryList, $shipping_country,'id="shipping_country" class="main_SELECT" onchange="getStateList(\'shippingState\',this.value,\'shipping_state\',\'main_SELECT\');"');
												?>
										</li>
										<li class="width_258 select select_2" id="shippingState">
											 <?php    
														$stateList = getStatesList($shipping_country,true); 
														$shipping_state=$userProfileData->shipping_state;
														$shipping_state=set_value('shipping_state')?set_value('shipping_state'):$shipping_state;
														echo form_dropdown('shipping_state', $stateList, $shipping_state,'class="main_SELECT"');
												?>
										</li>
										<li class="width_190"><?php echo form_input($shipping_zipInput); ?></li>
										<li><?php echo form_input($shipping_emailInput); ?></li>
										<li><?php echo form_input($shipping_phoneInput); ?></li>
								 </ul>
								 
								 <div class="fr btn_wrap display_block font_weight">
										<button class="red fr p10 bdr_a0a0a0 fshel_bold" type="button" onclick="$('#shippingForm').submit();" >Save</button>
								 </div>
								
							<?php echo form_close(); ?>
						</div>
				 </div>
			</div>
		
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$("#billingForm").validate({
		 submitHandler: function() {
			var fromData=$("#billingForm").serialize(); 
			$.post(baseUrl+language+'/dashboard/saveBuyerBilling',fromData, function(data) {
				if(data && data.msg){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
			  }
			}, "json");
		 }
	});
	$("#shippingForm").validate({
		 submitHandler: function() {
			var fromData=$("#shippingForm").serialize(); 
			$.post(baseUrl+language+'/dashboard/saveBuyershipping',fromData, function(data) {
				if(data && data.msg){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
			  }
			}, "json");
		 }
	});
});
function copyFromSeller(prifix){
			var countryId = parseInt('<?php echo $userProfileData->countryId;?>');
			
			$('#'+prifix+'_firstName').val('<?php echo $userProfileData->firstName;?>');
			$('#'+prifix+'_lastName').val('<?php echo $userProfileData->lastName;?>');
			$('#'+prifix+'_companyName').val('<?php echo $userProfileData->seller_companyName;?>');
			$('#'+prifix+'_address1').val('<?php echo $userProfileData->seller_address1;?>');
			$('#'+prifix+'_address2').val('<?php echo $userProfileData->seller_address2;?>');
			$('#'+prifix+'_city').val('<?php echo $userProfileData->seller_city;?>');
			$('#'+prifix+'_country').val(countryId);
			$('#'+prifix+'_state').val('<?php echo $userProfileData->seller_state;?>');
			$('#'+prifix+'_email').val('<?php echo $userProfileData->email;?>');
			$('#'+prifix+'_phone').val('<?php echo $userProfileData->seller_phone;?>');
			$('#'+prifix+'_zip').val('<?php echo $userProfileData->seller_zip;?>');
			
			if(countryId > 0){
				var divId = prifix+'State';
				var statedivId = prifix+'_state';
				getStateList(divId,countryId,statedivId,'main_SELECT','<?php echo $userProfileData->seller_state;?>');
			}
			$('#'+prifix+'_country').selectBoxJquery('value', countryId);
			
			
			
}
function copyFromBilling(prifix){
			var countryId = parseInt('<?php echo $userProfileData->billing_country;?>');
			$('#'+prifix+'_firstName').val('<?php echo $userProfileData->billing_firstName;?>');
			$('#'+prifix+'_lastName').val('<?php echo $userProfileData->billing_lastName;?>');
			$('#'+prifix+'_companyName').val('<?php echo $userProfileData->billing_companyName;?>');
			$('#'+prifix+'_address1').val('<?php echo $userProfileData->billing_address1;?>');
			$('#'+prifix+'_address2').val('<?php echo $userProfileData->billing_address2;?>');
			$('#'+prifix+'_city').val('<?php echo $userProfileData->billing_city;?>');
			$('#'+prifix+'_country').val(countryId);
			$('#'+prifix+'_state').val('<?php echo $userProfileData->billing_state;?>');
			$('#'+prifix+'_email').val('<?php echo $userProfileData->billing_email;?>');
			$('#'+prifix+'_phone').val('<?php echo $userProfileData->billing_phone;?>');
			$('#'+prifix+'_zip').val('<?php echo $userProfileData->billing_zip;?>');
			
			if(countryId > 0){
				var divId = prifix+'State';
				var statedivId = prifix+'_state';
				getStateList(divId,countryId,statedivId,'main_SELECT','<?php echo $userProfileData->billing_state;?>');
			}
			$('#'+prifix+'_country').selectBoxJquery('value', countryId);
			
}
</script>

