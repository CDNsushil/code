<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$lang=lang();

/*Paypal Details */

$paypalId = array(
	'name'=> 'paypalId',
	'class'	=>'email required',
	'id'=> 'paypalId',
	'value'	=> set_value('paypalId')?set_value('paypalId'):$userProfileData->paypalId,
	'onclick'=>"placeHoderHideShow(this,'PayPal ID','hide')",
	'onblur'=>"placeHoderHideShow(this,'PayPal ID','show')",
	'placeholder'=>"PayPal ID *"
	
 );

$paypalFirstName = array(
	'name'=> 'paypalFirstName',
	'class'	=>'required',
	'id'=> 'paypalFirstName',
	'value'	=> set_value('paypalFirstName')?set_value('paypalFirstName'):$userProfileData->paypalStreet,
	'onclick'=>"placeHoderHideShow(this,'First Name','hide')",
	'onblur'=>"placeHoderHideShow(this,'First Name','show')",
	'placeholder'=>"First Name *"
	
 );

$paypalLastName = array(
	'name'=> 'paypalLastName',
	'class'	=>'required',
	'id'=> 'paypalLastName',
	'value'	=> set_value('paypalLastName')?set_value('paypalLastName'):$userProfileData->paypalZip,
	'onclick'=>"placeHoderHideShow(this,'Last Name','hide')",
	'onblur'=>"placeHoderHideShow(this,'Last Name','show')",
	'placeholder'=>"PayPal ID *"
	
 );



/* Seller settings section */
$formAttributes = array(
	'name'=>'sellerSettingForm',
	'id'=>'sellerSettingForm'
);

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
	'value'=> set_value('seller_email')?set_value('seller_email'):$userProfileData->email,
	'onclick'=>"placeHoderHideShow(this,'Email *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Email *','show')",
	'placeholder'=>"Email *",
	'maxlength'=> 50,
	'size'=> 50,
	'disabled' =>'disabled'
);

$countryValue = ($userProfileData->countryId!='') ? $userProfileData->countryId : 0;
$stateValue = ($userProfileData->seller_state!='') ? $userProfileData->seller_state : 0;

/* End*/

/*Seller Shipping Pickup settings */

$formpickupAttributes = array(
	'name'=>'pickupForm',
	'id'=>'pickupForm'
);
$seller_pickupcity = array(
	'name'	=> 'seller_pickupcity',
	'id'	=> 'seller_pickupcity',
	'class'	=> 'required font_wN width_315',
	'value'	=> set_value('seller_pickupcity')?set_value('seller_pickupcity'):$userProfileData->pickup_city,
	'onclick'=>"placeHoderHideShow(this,'City *','hide')",
	'onblur'=>"placeHoderHideShow(this,'City *','show')",
	'placeholder'=>"City *",
	'maxlength'	=> 50,
	'size'	=> 50
);

$seller_pickupzip = array(
	'name'=> 'seller_pickupzip',
	'id'=>'seller_pickupzip',
	'class'=> 'number required font_wN width_130',
	'value'=> set_value('seller_pickupzip')?set_value('seller_pickupzip'):$userProfileData->pickup_zip,
	'onclick'=>"placeHoderHideShow(this,'Post Code or ZIP Code *','hide')",
	'onblur'=>"placeHoderHideShow(this,'Post Code or ZIP Code *','show')",
	'placeholder'=>"Post Code or ZIP Code *",
	'maxlength'	=> 50,
	'size'	=> 50
);

$seller_pickupsuberb = array(
	'name'=> 'seller_pickupsuberb',
	'id'=>'seller_pickupsuberb',
	'class'=> 'font_wN width_315',
	'value'=> set_value('seller_pickupsuberb')?set_value('seller_pickupsuberb'):$userProfileData->pickup_subrub,
	'onclick'=>"placeHoderHideShow(this,'Suburb','hide')",
	'onblur'=>"placeHoderHideShow(this,'Suburb','show')",
	'placeholder'=>"Suburb ",
	'maxlength'	=> 50,
	'size'	=> 50
);

$seller_pickupdesc = array(
	'name'=> 'seller_pickupdesc',
	'id'=>'seller_pickupdesc',
	'class'=> 'font_wN width610 p10 red_bdr_2 height_89 radius0',
	'type' => 'textarea',
	'value'=> set_value('seller_pickupdesc')?set_value('seller_pickupdesc'):'',
	'onclick'=>"placeHoderHideShow(this,'Special Pickup Requirements','hide')",
	'onblur'=>"placeHoderHideShow(this,'Special Pickup Requirements','show')",
	'placeholder'=>"Special Pickup Requirements ",
	'maxlength'	=> 50,
	'size'	=> 50
);

$pickupCountryValue = ($userProfileData->pickup_country!='') ? $userProfileData->pickup_country : 0;
$pickupStateValue = ($userProfileData->pickup_state!='') ? $userProfileData->pickup_state : 0;

/* Domestic Shipping */
$formdomesticShipping = array(
	'name'=>'domseticShippingForm',
	'id'=>'domseticShippingForm'
);
$domesticCountry = ($shippingdetails[0]->countryId!='') ? $shippingdetails[0]->countryId : 0;
$deliveryInformation = ($shippingdetails[0]->deliveryInformation!='') ? $shippingdetails[0]->deliveryInformation : '';



/* Currency Page */
	$eur=$us= '';
	$classnocur = 'style=display:none';
	$menuClickable = 'dn';
	$menuNotClickable = '';	
	//$userProfileData->seller_currency ='';
	if(isset($userProfileData->seller_currency) && ($userProfileData->seller_currency!='' )) {
		$classcur ='style=display:none';
		$classnocur='';
		$menuClickable='';
		$menuNotClickable ='dn';
		switch($userProfileData->seller_currency){
			case 1: 
			$text ='US Dollars $';
			$eur  ='dn';
			$is_euro_selected = 'checked';
			$is_usd_selected = '';
			break;

			default: 
			$text ='Euros €';
			$us  ='dn';
			$is_euro_selected = '';
			$is_usd_selected = 'checked';
			break;
		}
	}
?>


<div class="TabbedPanelsContentGroup main_tab m_auto ">            

	<!--========================== Setter setting ==============================-->

	<div class="TabbedPanelsContent TabbedPanelsContentVisible">
		<div id="TabbedPanels5" class="TabbedPanels tab_setting">

				<!--========================== stage 2 :- second tab  ==============================-->

				<ul class="TabbedPanelsTabGroup width100_per not_clickable <?php echo $menuNotClickable ?>">
					<li class="TabbedPanelsTab ssSabMenu TabbedPanelsTabSelected" ><a href="javascript:void(0)" ><span><?php echo $this->lang->line('subheadingCurrency');?> </span></a></li>
					<li class="TabbedPanelsTab cunsum_tax ssSabMenu"><a href="javascript:void(0)" ><span><?php echo $this->lang->line('subheadingConsumptionTax');?></span></a></li>
					<li class="TabbedPanelsTab ssSabMenu" ><a href="javascript:void(0)" ><span><?php echo $this->lang->line('subheadingPayPal');?></span></a></li>
					<li class="TabbedPanelsTab ssSabMenu "><a href="javascript:void(0)" ><span><?php echo $this->lang->line('subheadingSellerDetails');?></span></a></li>
					<li class="TabbedPanelsTab ssSabMenu" ><a href="javascript:void(0)" ><span> <?php echo $this->lang->line('subheadingShipping');?></span></a></li>
				</ul>
				
				<ul class="TabbedPanelsTabGroup width100_per clickable <?php echo $menuClickable ?>">
					<li class="TabbedPanelsTab ssSabMenu TabbedPanelsTabSelected" tabindex="0" id="cdMenu" onclick="hideShow(this,'#cd','.ssContents','slow','.ssSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)" ><span><?php echo $this->lang->line('subheadingCurrency');?> </span></a></li>
					<li class="TabbedPanelsTab cunsum_tax ssSabMenu" tabindex="0" id="ctMenu" onclick="hideShow(this,'#ct','.ssContents','slow','.ssSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)" ><span><?php echo $this->lang->line('subheadingConsumptionTax');?></span></a></li>
					<li class="TabbedPanelsTab ssSabMenu" tabindex="0" id="pdMenu" onclick="hideShow(this,'#pd','.ssContents','slow','.ssSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)" ><span><?php echo $this->lang->line('subheadingPayPal');?></span></a></li>
					<li class="TabbedPanelsTab ssSabMenu " tabindex="0" id="sdMenu" onclick="hideShow(this,'#sd','.ssContents','slow','.ssSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)" ><span><?php echo $this->lang->line('subheadingSellerDetails');?></span></a></li>
					<li class="TabbedPanelsTab ssSabMenu" tabindex="0" id="shMenu" onclick="hideShow(this,'#sh','.ssContents','slow','.ssSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)" ><span> <?php echo $this->lang->line('subheadingShipping');?></span></a></li>
				</ul>
					
					<div class="TabbedPanelsContentGroup ssContents" id="cd">

						<!-- =================Currency type==================-->						

						<div class="TabbedPanelsContent TabbedPanelsContentVisible"> 
							
						<div class="c_1 main_price" <?php echo $classcur ?>>
						<h3 class="red fs21 fnt_mouse  bb_aeaeae width635 whitespace_now"><?php echo $this->lang->line('whatSellerCurrency');?> </h3>
						<div class="sap_40"></div>
						<ul class=" display_table clearb rate_wrap">
						<li class="defaultP ">
						<label class=" pr80 Eu_btn">
						<input  type="radio" name="seller_currency" value="0" <?php echo $is_euro_selected ?> >
						<?php echo $this->lang->line('sellerEuros');?> </label>
						<label class="Us_btn">
						<input  type="radio" name="seller_currency" value="1" <?php echo $is_usd_selected ?> >
						<?php echo $this->lang->line('sellerUSDollars');?> </label>
						</li>
						</ul>

						<ul class="org_list">
						<li class="icon_1 red"><?php echo $this->lang->line('currencyMsgsale');?></li>
						<li class="icon_2"><?php echo $this->lang->line('currencyMsgchange');?></li>
						</ul>

						<div class="fr btn_wrap display_block font_weight">
										
                         <button class="red fr p10 bdr_a0a0a0" onclick="saveSellerCurrency()" type="button"><?php echo $this->lang->line('save');?></button>
                       
						</div>
						</div> 

						<div class="c_1 us_wrap" <?php echo $classnocur ?>>
						<h3 class="red fs21 fnt_mouse  bb_aeaeae width635 selling_text ">You are selling in <?php echo $text ?></h3>
						<div class="sap_40"></div>
						<ul>
						<li class="icon_1 red"><?php echo $this->lang->line('currencyMsgsale');?></li>
						<li class="icon_2"><?php echo $this->lang->line('currencyMsgchangeshrt');?></li>
						</ul>
						<div class="btn_wrap fr">
                          <a href="javascript:void(0)" >  <button class="fl p10 bdr_a0a0a0 Euros" onclick="showCurrencyForm();"  type="button"><?php echo $this->lang->line('back');?></button></a>
                          <a href="javascript:void(0)" >  <button class="p10 ml10 bdr_a0a0a0 b_F1592A" onclick="showConsumptionTab();"  type="button"><?php echo $this->lang->line('next');?></button></a>
                          
						</div>
						</div>
						
						</div>
					
					</div>

					<div class="TabbedPanelsContentGroup ssContents dn" id="ct">
						<!-- =================Consumption Tax==================-->
						<div id="consumption_tax_div" > 
							<?php $this->load->view('consumption_tax');?>	
						</div>
						<div id="charge_consumption_tax_div" class="dn"> 
							<?php $this->load->view('charge_consumption_tax');?>	
						</div>
						<div id="consumption_state_tax_div" class="dn"> 
							<?php $this->load->view('consumption_state_tax');?>	
						</div>
					</div>
          
          <div class="TabbedPanelsContentGroup ssContents dn" id="pd">
						 <!-- =================PayPal==================-->
<?php 
if(isset($userProfileData->verify_status) && ($userProfileData->verify_status == 't')){ 
 $classVerfiedYes = '';
 $classVerfiedNo = 'dn';
}else{
 $classVerfiedYes = 'dn';
 $classVerfiedNo = '';
}?>

						 <div class="TabbedPanelsContent TabbedPanelsContentVisible">
							 <form id="paypalSettingForm" name="paypalSettingForm">
								<div class="c_1">
									 <h3 class="red fs21 fnt_mouse  bb_aeaeae "><?php echo $this->lang->line('paypalDetails');?></h3>
									 <div class="sap_40"></div>
									 <input type="hidden" id="verify_detail"  name="verify_detail" />
									 <input type="hidden" id="verify_paypal"  name="verify_status" value="<?php echo $userProfileData->verify_status?>" />
									 <ul class=" display_table paypal clearb rate_wrap ">
											<li><?php echo form_input($paypalId); ?></li>
											<li><?php echo form_input($paypalFirstName);?></li>												 
											<li><?php echo form_input($paypalLastName); ?></li>
												
											
											<li class="fr mt20 mr5 verify pb0"> <span class="defaultP fl">
												 <button type="button" class="verify_btn <?php  echo $classVerfiedYes ?> "> <?php echo $this->lang->line('verified');?> </button>
												 <button type="button" class="check_btn <?php  echo $classVerfiedNo ?>"><?php echo $this->lang->line('checkDetails');?></button>
												<!-- <button type="submit" class="fr p10 bdr_a0a0a0 "  onclick="return verifyPaypal();">Verify</button> -->
												 
												 <button class="b_F1592A bdr_F1592A ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="return verifyPaypal();" type="submit" role="button" aria-disabled="false"><span class="ui-button-text">Verify</span></button>
												 
												 
												 </span>
											</li>
									 </ul>
									 <ul class="org_list">
											<li class="icon_1 red"><?php echo $this->lang->line('currencyMsgchangeshrt');?>  </li>
											<li class="icon_2 "><?php echo $this->lang->line('verifypaypalMsg');?> </li>
											
									 </ul>
									 <div class="fr btn_wrap display_block font_weight">
											<button class="fl red p10 bdr_a0a0a0" onclick="savePaypalInfo();" type="button"><?php echo $this->lang->line('save');?></button>          
									 </div>
								</div>
						 </div>
					</form>	 
					</div>
           
          <div class="TabbedPanelsContentGroup ssContents dn" id="sd">
																										
								<!-- ================= Seller Details ==================-->

								 <div class="TabbedPanelsContent TabbedPanelsContentVisible">
												<div class="wra_head clearb">
													<h3 class="red fs21 fnt_mouse bb_aeaeae"> <?php echo $this->lang->line('whatSellerDetails');?> </h3>
													<div class="sap_40"></div>
													<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
													<div class=" display_inline_block defaultP">
													<label class="pr20"> 
														<input  type="radio" <?php if($userProfileData->seller_isSameAsBuyer=='t'){ echo 'checked'; }?> id="seller_isSameAsBuyer" name="detail_type" value="seller_isSameAsBuyer" onclick="if(this.checked){copyFromBuyer('#seller_')};"  />
														<?php echo $this->lang->line('sameAsBuyerDetails');?>
													</label>
													<label>
														<input  type="radio" <?php if($userProfileData->isSameAsShipping=='t'){ echo 'checked'; }?> id="seller_isSameAsShipping" name="detail_type" value="seller_isSameAsShipping" onclick="if(this.checked){copyFromShipping('#seller_')};"  />
														<?php echo $this->lang->line('sellersameAsShippDetails');?>
													</label>
													</div>
													<div class="sap_40"></div>
													
														<ul class=" billing_form form1" >
														<li><?php echo form_input($seller_firstName); ?></li>
														<li><?php echo form_input($seller_lastName); ?></li>
														<li><?php echo form_input($seller_company); ?></li>
														<li><?php echo form_input($seller_address1Input); ?></li>
														<li><?php echo form_input($seller_address2Input); ?></li>
														<li><?php echo form_input($seller_cityInput); ?></li>
														
														<li class=" width_258 select select_1">
														<?php
														  $countries = getCountryList();
														  echo form_dropdown('seller_country', $countries, $countryValue,'id="countriesList" disabled class=" main_SELECT countriesList selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
													   ?>
									                  </li>
													<li class=" width_258 select select_2">
														<?php
														$stateList = (!empty($countryValue))?getStatesList($countryValue,true):array(''=>'Select  State, Province or Region');
														echo form_dropdown('seller_state', $stateList, $stateValue,'id="stateList" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
														?>
														</li>
														<li class="width_190"><?php echo form_input($seller_zipInput); ?></li>
														<li><?php echo form_input($seller_emailInput); ?></li>
														<li class="mb0"><?php echo form_input($seller_phoneInput); ?></li>
                                            
														</ul>
																		
																			
													<div class="fr btn_wrap display_block font_weight">
														<button class="p10 red bdr_a0a0a0" onclick ="return saveSellerSettings();" type="submit"><?php echo $this->lang->line('save');?></button>          </div>
																		</div>
												<?php echo form_close(); ?>						
											</div>
											
															 
									</div>
          
          <div class="TabbedPanelsContentGroup ssContents dn" id="sh">
							 <!-- ================= Shipping Details ==================-->
							 <div class="TabbedPanelsContent shipContent TabbedPanelsContentVisible">
									<div id="TabbedPanels6" class="TabbedPanels tab_setting second_inner">
										 <!--========== Setup your Auction  =================-->
										 <ul class="TabbedPanelsTabGroup width100_per">
												<li class="TabbedPanelsTab SSSabMenu TabbedPanelsTabSelected" id="picSabMenu" onclick="hideShow(this,'#pic','.SSSContents','slow','.SSSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)"><span><?php echo $this->lang->line('subheadingPickup');?></span></a></li>
												<li class="TabbedPanelsTab SSSabMenu" id="dsSabMenu" onclick="hideShow(this,'#ds','.SSSContents','slow','.SSSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)"><span><?php echo $this->lang->line('subheadingDS');?></span></a></li>
												<li class="TabbedPanelsTab SSSabMenu" id="isSabMenu" onclick="hideShow(this,'#IS_Container','.SSSContents','slow','.SSSabMenu','TabbedPanelsTabSelected');"><a href="javascript:void(0)"><span><?php echo $this->lang->line('subheadingIS');?></span></a></li>
										 </ul>
										 <div class="TabbedPanelsContentGroup SSSContents" id="pic">
												<!--=======================pickup=======================-->
												<div class="TabbedPanelsContent TabbedPanelsContentVisible">
										<?php echo form_open($this->uri->uri_string(),$formpickupAttributes); ?>
													 <div class="c_1">
															<h3 class="red fs21 fnt_mouse  bb_aeaeae"> <?php echo $this->lang->line('pickupDetails');?></h3>
															<ul class=" mt30 mb20 billing_form domestic_country position_relative height_30">
																 <li class="select select_1 width_208">
																	<?php
																	$countries = getCountryList();
																	echo form_dropdown('seller_pickupcountry', $countries, $pickupCountryValue,'id="countriesList" class=" main_SELECT countriesList selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
																	?>
																 </li>
																 <li class="select_2 select width_208 stateListDiv">
																		<?php
																			$stateList = (!empty($pickupCountryValue))?getStatesList($pickupCountryValue,true):array(''=>'Select  State');
																			echo form_dropdown('stateList', $stateList, $pickupStateValue,'id="stateList" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
																			?>
																 </li>
																 <li class="width_345"><?php echo form_input($seller_pickupcity); ?></li>
																 <li class="width_345"><?php echo form_input($seller_pickupsuberb); ?></li> 
																 <li class="width_160"><?php echo form_input($seller_pickupzip); ?></li>
															</ul>
															<div class="wra_head">
																 <h4 class="red fs21 mb25 fnt_mouse  bb_aeaeae"><?php echo $this->lang->line('pickupReq');?></h4>
																 <textarea class="font_wN width610 p10 red_bdr_2 height_89 radius0" value="Special Pickup Requirements" onclick="placeHoderHideShow(this,'Special Pickup Requirements','hide')" onblur="placeHoderHideShow(this,'Special Pickup Requirements','show')" placeholder="Special Pickup Requirements" name="seller_pickupdesc" cols="" rows=""><?php echo isset($userProfileData->pickup_requirements) ? $userProfileData->pickup_requirements : '' ?></textarea>
																 <ul class="org_list">
																		<li class="icon_2 "><?php echo $this->lang->line('pickupMsg');?></li>
																 </ul>
															</div>
															<div class="fr btn_wrap display_block font_weight">
																 <button class="red fl p10 bdr_a0a0a0" onclick ="return savePickupDetails();" type="submit"><?php echo $this->lang->line('save');?></button>          
															</div>													
													 </div>
												</div>
									<?php echo form_close(); ?>
										 </div>
									
										 <div class="TabbedPanelsContentGroup SSSContents dn" id="ds"> 

												<!--=======================Domestic======================-->

												<div class="TabbedPanelsContent TabbedPanelsContentVisible">
                              <?php echo form_open($this->uri->uri_string(),$formdomesticShipping); ?>
													<div class="c_1">
														<h3 class="red fs21 fnt_mouse  bb_aeaeae"><?php echo $this->lang->line('domesticShipping');?></h3>
														<ul class=" mt30 mb20 billing_form domestic_country position_relative height_30">
															<li class="select width_208">
																<?php
																	$countries = getCountryList();
																	echo form_dropdown('domestic_shippingcountry', $countries, $domesticCountry,'id="domestic_shippingcountry" class=" main_SELECT selectBox bg_f6f6f6 required" title="'.$this->lang->line('packpayment_required_field').'"');
																	?>
															</li>
														</ul>
															
														<div class="wra_head ">
															<h4 class="red fs21 mb25 fnt_mouse  bb_aeaeae"><?php echo $this->lang->line('deliveryInfo');?> </h4>
															<textarea class="required font_wN width610 p10 red_bdr_2 height_89 radius0" value="Delivery Information*" type="text" onclick="placeHoderHideShow(this,'Delivery Information*','hide')" onblur="placeHoderHideShow(this,'Delivery Information*','show')" placeholder="Delivery Information*" id="delivery_information" name="delivery_information"><?php echo $deliveryInformation ?></textarea>
															<ul class="org_list">
																<li class="icon_2 "><?php echo $this->lang->line('dsShippingMsg');?></li>
															</ul>
														</div>
															
														<div class="fr btn_wrap display_block font_weight">
															<a href="javascript:void(0)"><button class="red fl p10 bdr_a0a0a0" onclick="getDomesticState();" type="submit"><?php echo $this->lang->line('next');?></button></a>
													</div>
												</div>

												</div>
									<?php echo form_close(); ?>
											<!--======================= End Domestic======================-->
											</div>
											
										 <div id="showDomesticState"></div>
											 
									    <?php $this->load->view('seller_international_shipping');?>   
											  
											</div>
							 </div>
						</div>                                                           
		<!--End Groub--> 
		</div>
	</div>       

</div>
<script>

/* Currency Section */	
function saveSellerCurrency (){
	var currency = $('input[name=seller_currency]:checked').val();
	$.ajax
	({     		
		url: baseUrl+language+"/dashboard/saveSellerCurrency/"+currency,
		success: function(msg){
			//$('.main_price').addClass('dn');
			//$('.us_wrap').removeClass('dn');
			$('#cd').html(msg);
			$('.not_clickable').addClass('dn');
			$('.clickable').removeClass('dn');
			//if(currency==0){
			//	$('.selling_text').html('You are selling in Euros €')
			//}else {
			//	$('.selling_text').html('You are selling in US Dollars $')
			//}
		}
	});    
}

/* Paypal Verify Section */
	function verifyPaypal(){
		var returnFlagPay = <?php echo ($userProfileData->verify_status == 'f')?'false':'true'; ?>;
		var paypalId = $('#paypalId').val();
		var paypalFirstName = $('#paypalFirstName').val();
		var paypalLastName = $('#paypalLastName').val();
		
		$('#paypalSettingForm').validate();     
		
		 if (paypalId==''){
			 $('#paypalId').addClass('error');
			 e.preventDefault();
			 }
		  if (paypalFirstName==''){
			 $('#paypalFirstName').addClass('error');
			 e.preventDefault();
			 }
			 
		if (paypalLastName==''){
			 $('#paypalId').addClass('error');
			 e.preventDefault();
			 } 
		
        if (paypalId!='' && paypalFirstName!='' && paypalId!='') {
			
			 fromData = 'val1='+paypalId+'&val2='+ paypalFirstName+'&val3='+ paypalLastName+'&ajaxHit=1';
			 loader();
			 /* Send the data using post */
			var posting = $.post(baseUrl+language+'/common/verifyPaypalaccount',					
				fromData,							
				function(data) {
					var checkSuccess = data.Ack;
					
					json_object = JSON.stringify(data);
					$('#verify_detail').val(json_object);
					if(data.Ack =="Error"){
						$('.verify_btn').addClass('dn');
						$('.check_btn').removeClass('dn');
						$('#verify_paypal').val('f');
						customAlert('<?php echo $this->lang->line('tryLaterVerifyPaypal');?>'); 
						returnFlagPay = false; 
						
					}
					else if(data.Ack =="Success"){
						$('.check_btn').addClass('dn');
						$('.verify_btn').removeClass('dn');
						$('#verify_paypal').val('t');
						returnFlagPay = true;
						customAlert('Paypal information verified.');											
						//$('#messageSuccessError').html('<div class="successMsg">Paypal information verified.</div>');
						//timeout = setTimeout(hideDiv, 5000);
						return true;
					}
					else{
						$('.verify_btn').addClass('dn');
						$('.check_btn').removeClass('dn');	
						$('#verify_paypal').val('f');													
						customAlert('<?php echo $this->lang->line('inValidVerifyPaypal');?>'); 
						notValidPayInfo = 'notValid'; 		
						returnFlagPay = false; 									
					}								

				},
				
				'json');
        }
      return false; 
    }

function savePaypalInfo(){
		var paypalId = $('#paypalId').val();
		var paypalFirstName = $('#paypalFirstName').val();
		var paypalLastName = $('#paypalLastName').val();
		var verify_status = $('#verify_paypal').val();
		var verify_detail = $('#verify_detail').val();
		
		 if (paypalId==''){
			 $('#paypalId').addClass('error');
			 e.preventDefault();
			 }
		  if (paypalFirstName==''){
			 $('#paypalFirstName').addClass('error');
			 e.preventDefault();
			 }			 
		if (paypalLastName==''){
			 $('#paypalId').addClass('error');
			 e.preventDefault();
			 } 
	    if (paypalId!='' && paypalFirstName!='' && paypalLastName!='' && verify_status=='t' ) {
		  var returnFlag=false;
		  returnFlag=ajaxSave('<?php echo base_url(lang()."/dashboard/savePaypalInfo");?>','',paypalId,paypalFirstName,paypalLastName,verify_detail);   		
		  customAlert('Paypal information updated');
	   }else {
		      customAlert('<?php echo $this->lang->line('inValidVerifyPaypal');?>');
		    }
  }
/* End */

/* Seller selling details */
	function saveSellerSettings(){		
		$("#sellerSettingForm").validate({
			submitHandler: function(form) {
				var fromData=$("#sellerSettingForm").serialize();
                    //fromData = fromData+'&ajaxHit=1'+'&replymsg='+body;
				$.post( baseUrl+language+'/dashboard/saveSellerSettings',fromData, function( data ) {
					if(data && data.msg){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
						}
				}, "json");
			}
		});
    }
/* End */

/*Save Pickup Details */
function savePickupDetails(){
		$("#pickupForm").validate({
			submitHandler: function(form) {
				var fromData=$("#pickupForm").serialize();
                    //fromData = fromData+'&ajaxHit=1'+'&replymsg='+body;
				$.post( baseUrl+language+'/dashboard/shippingPickupInfo',fromData, function( data ) {					
					if(data && data.msg){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						timeout = setTimeout(hideDiv, 5000);
						}
				}, "json");
			}
		});
    }
/*End*/

/* Domestic shipping details */
	function getDomesticState(){		
		$("#domseticShippingForm").validate({
			submitHandler: function(form) {
				var fromData=$("#domseticShippingForm").serialize();
                    //fromData = fromData+'&ajaxHit=1'+'&replymsg='+body;
				$.post( baseUrl+language+'/dashboard/getDomesticState',fromData, function( data ) {
					if(data){
						$('#ds').hide("slow");
						$('#showDomesticState').html(data);
					}
				});
			}
		});
    }

function showDomesticShipping(){
	hideShow(this,'#ds','.SSSContents','slow','.SSSabMenu','TabbedPanelsTabSelected');
	}

function showConsumptionTab(){
	hideShow(this,'#ct','.ssContents','slow','.ssSabMenu','TabbedPanelsTabSelected');
	$('#ctMenu').addClass('TabbedPanelsTabSelected');
	}
	
	
  
function copyFromBuyer(prifix){		
		$(prifix+'address1').val('<?php echo $userProfileData->billing_address1;?>');
		$(prifix+'address2').val('<?php echo $userProfileData->billing_address2;?>');
		$(prifix+'city').val('<?php echo $userProfileData->billing_city;?>');
		$(prifix+'state').val('<?php echo $userProfileData->billing_state;?>');
		$(prifix+'phone').val('<?php echo $userProfileData->billing_phone;?>');
		$(prifix+'zip').val('<?php echo $userProfileData->billing_zip;?>');
		$('SELECT').selectBox(); 
}

function copyFromShipping(prifix){		
		$(prifix+'address1').val('<?php echo $userProfileData->shipping_address1;?>');
		$(prifix+'address2').val('<?php echo $userProfileData->shipping_address2;?>');
		$(prifix+'city').val('<?php echo $userProfileData->shipping_city;?>');		
		$(prifix+'state').val('<?php echo $userProfileData->shipping_country;?>');		
		$(prifix+'phone').val('<?php echo $userProfileData->shipping_phone;?>');
		$(prifix+'zip').val('<?php echo $userProfileData->shipping_zip;?>');
		$('SELECT').selectBox(); 			
}

function showCurrencyForm (){
	var currency = 1;
	$.ajax
	({     
		type: "POST",		
		url: baseUrl+language+'/dashboard/showCurrencyForm',
		success: function(msg){			
			$('#cd').html(msg);
			$('.not_clickable').removeClass('dn');
			$('.clickable').addClass('dn');
			$('#cdMenu').addClass('TabbedPanelsTabSelected');
			
		}
	});    
}



</script>
