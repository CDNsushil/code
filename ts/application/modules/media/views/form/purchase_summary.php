<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$purchase_form = array(
		'name'=>'purchase_summary',
		'id'=>'purchase_summary'
	);
	// set modify button
	$madifyButton   =   array(
	  'name'        =>  'madify',
	  'id'          =>  'madify',
	  'content'     =>  $this->lang->line('modify_purchase'),
	  'class'       =>  'fr  back_click_1 bg_F0F0F0 bdr_b1b1b1',
	  'type'        =>  'button',
	);
	// set terms n condition checkbox
	$paymentTermCondition = array(
		'name'    =>  'paymentTermCondition',
		'id'      =>  'paymentTermCondition',
		'value'   =>  '1',
		'type'    =>  'checkbox',
		'class'   => 'ez-hide width_auto',
	);

	// set buyer billing setting data
	$firstNameValue       =   (!empty($buyerSettingData->billing_firstName))?$buyerSettingData->billing_firstName:"";
	$lastNameValue        =   (!empty($buyerSettingData->billing_lastName))?$buyerSettingData->billing_lastName:"";
	$companyNameValue     =   (!empty($buyerSettingData->billing_companyName))?$buyerSettingData->billing_companyName:"";
	$addressLine1Value    =   (!empty($buyerSettingData->billing_address1))?$buyerSettingData->billing_address1:"";
	$addressLine2Value    =   (!empty($buyerSettingData->billing_address2))?$buyerSettingData->billing_address2:"";
	$townOrCityValue      =   (!empty($buyerSettingData->billing_city))?$buyerSettingData->billing_city:"";
	$stateValue           =   (!empty($buyerSettingData->billing_state))?getstateName($buyerSettingData->billing_state):"";
	$countryValue         =   (!empty($buyerSettingData->billing_country))?getCountry($buyerSettingData->billing_country):"";
	$zipCodeValue         =   (!empty($buyerSettingData->billing_zip))?$buyerSettingData->billing_zip:"";
	$phoneNumberValue     =   (!empty($buyerSettingData->billing_phone))?$buyerSettingData->billing_phone:"";
	$emailValue           =   (!empty($buyerSettingData->billing_email))?$buyerSettingData->billing_email:"";
	
	// set toad currency sign
	$toadCurrencySign     = $this->config->item('toadCurrencySgine');
	// set form url
	$absoluteFormUrl = base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method());
?>
<!--
	<ul class="TabbedPanelsTabGroup second_ul pt20 pb20">
		<li class="TabbedPanelsTab" ><a href="<?php echo $absoluteFormUrl;?>"><span><?php echo $this->lang->line('showcaseStep1');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="<?php echo $absoluteFormUrl.'/membershipcart';?>"><span><?php echo $this->lang->line('showcaseStep2');?></span></a></li>
		<li class="TabbedPanelsTab" ><a href="<?php echo $absoluteFormUrl.'/billingdetails';?>"><span><?php echo $this->lang->line('showcaseStep3');?></span></a></li>
		<li class="TabbedPanelsTab TabbedPanelsTabSelected" ><a href="<?php echo $absoluteFormUrl.'/purchasesummary';?>"><span><?php echo $this->lang->line('showcaseStep4');?></span></a></li>
		<li class="TabbedPanelsTab" >  <a href="javascript:void(0)"><span><?php echo $this->lang->line('showcaseStep5');?></span> </a></li>
	</ul>
-->
	<div class="TabbedPanelsContentGroup width_665 m_auto "> 
		<?php echo form_open(base_url(lang().'/membershipcart/payments_pro/mediacartpayment'),$purchase_form); ?>
			<div class="TabbedPanelsContent">
				<h3> <?php echo $this->lang->line('purchaseSummary');?> </h3>
				<ul class="total  purcharse clearb mt40" >
					<li class="clearb space_1" >
						<span class="display_cell p_head"> 
							<span class="fs16 font_bold minwidth_165 "><?php echo $this->lang->line('media_showcase');?></span> 
							<span class="fs13 pl5"> <?php echo $this->lang->line('validOneYear');?></span>
						</span>
						<span class="price">
							<?php echo $toadCurrencySign.$containerPrice;?>
						</span>
					</li>
					<li class="clearb  BB_dadada" >
						<span class="display_cell p_head ">  
							<span class="fs16 font_bold minwidth_165"><?php echo $this->lang->line('extraSpace');?></span> 
							<span class="fs13 font_notmal pl5">
								<?php echo $spaceSize.$spaceUnit?>
							</span>
						</span>
						<span class="price "> <?php echo $toadCurrencySign.$spacePrice;?> </span> 
					</li>
					<li class="clearb  space_1 " >
						<span class="p_head pr36 text_alignR "> 
							<?php 
							echo $this->lang->line('vat');
							echo $this->config->item('VATpercentage');
							echo $this->lang->line('percente');
							?>
						</span>
						<span class="price "> 
							<?php echo $toadCurrencySign.$vatPrice;?> 
						</span> 
					</li>
					<li class="clearb BT_dadada" >
						<span class="red p_head font_bold pr36 text_alignR "> <?php echo $this->lang->line('total');?> </span>
						<span class="price red font_bold"> 
							<?php echo $toadCurrencySign.($totalPrice+$vatPrice);?> 
						</span> 
					</li>
				</ul>
				<div class="sap_65"></div>
				<div class="bill_detail clearb color_666 ">
					<span class="fl billcontent"> 
						<h4 class="fs21 fl red clearb "> <?php echo $this->lang->line('billingDetails');?></h4>
						<div class="sap_15"></div>
                        <p><?php echo $firstNameValue.' '.$lastNameValue ?></p>
                        <?php if(!empty($addressLine1Value) || $addressLine2Value) { ?>
                            <p><?php echo $addressLine1Value;?><?php echo (!empty($addressLine2Value))?', '.$addressLine2Value:'';?></p>
                        <?php } ?>
                        <?php if(!empty($townOrCityValue) || $stateValue) { ?>
                            <p><?php echo $townOrCityValue;?>, <?php echo $stateValue;?></p>
                        <?php } ?>
                        <?php if(!empty($zipCodeValue)) { ?>
                            <p><?php echo $zipCodeValue;?></p>
                         <?php } ?>
                        <p><?php echo $countryValue;?></p>
                        <p><?php echo $emailValue;?></p>
                        <p><?php echo $phoneNumberValue;?></p>
					</span>
					
					<span class="fr mr60 shipcontent">
						 <h4 class="fs21 fl red clearb "> <?php echo $this->lang->line('shippingDetails');?></h4>
						<div class="sap_15"></div>
						<?php if(!empty($userSellerData)) { ?> 
							<p><?php echo $userSellerData->firstName.' '.$userSellerData->lastName ?></p>
                            <?php if(!empty($userSellerData->seller_address1) || $userSellerData->seller_address2) { ?>
                                <p><?php echo $userSellerData->seller_address1;?><?php echo (!empty($userSellerData->seller_address2))?', '.$userSellerData->seller_address2:'';?></p>
							<?php 
                            } 
                            if(!empty($userSellerData->seller_city) || $userSellerData->seller_state) { ?>
                                <p><?php echo $userSellerData->seller_city;?>, <?php echo (!empty($userSellerData->seller_state))?getstateName($userSellerData->seller_state):"";?></p>
							<?php 
                            } 
                            if(!empty($userSellerData->seller_zip)) { ?>
                                <p><?php echo $userSellerData->seller_zip;?></p>
                            <?php 
                            }?>
							<p><?php echo (!empty($userSellerData->countryId))?getCountry($userSellerData->countryId):"";?></p>
							<p><?php echo $userSellerData->email;?></p>
							<p><?php echo $userSellerData->seller_phone;?></p>
						<?php } ?>
					</span>
					<div class="sap_30"></div>
					<p>
						<a href="<?php echo $absoluteFormUrl.'/billingdetails'; ?>">
							<?php echo form_button($madifyButton); ?>
						</a>
					</p>
				</div>
				<div class=" sap_50"></div>
				<div class="bdr_non clearb ml2 fl">
					<label class="defaultP ml0">
						<?php  echo form_input($paymentTermCondition); ?> 
						<?php  echo $this->lang->line('payment_acknowledge_1'); ?> 
						<a href="<?php echo base_url(lang().'/cms/termsncondition'); ?>"  target="_blank">
							<?php  echo $this->lang->line('payment_acknowledge_2'); ?>
						</a> 
						<?php  echo $this->lang->line('payment_acknowledge_3'); ?>   
					</label>
				</div>
				<div class="validation_error dn pt_15" id="payment_term_error" >
					<?php echo $this->lang->line('packstage2_error_messag'); ?>
				</div>
				<div class=" sap_25"></div>
				<ul class="fl lineH20 pt3 fs12 ul_wrap ml36">
					<li class="  mt3 "> 
						<span class="fl"><?php echo $this->lang->line('paySecurely');?> </span>
						<img src="<?php echo base_url('images/paypal_logo.png');?>" alt="a" class=" fl display_inline pl15 lineH24" />
					</li>
				</ul>
				<?php 
				$data['backUrl'] = base_url($this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'billingdetails');
				$this->load->view('common_view/common_buttons',$data);
				?>
			</div>
		<?php
		// close purchase summary form
		echo form_close();
		?>
	</div>
	
	<script>
	  /**
	   * @Description: This function for billing form validation
	   */
	   $("#purchase_summary").submit(function() {
		 
		var getChkStatus= $('#paymentTermCondition').is(":checked");
		   if(getChkStatus){
			  $('#payment_term_error').hide();
			  window.location.href="<?php echo base_url(lang().'/membershipcart/payments_pro/mediacartpayment') ?>";
		   }else{
			 $('#payment_term_error').show();
		   }
		 return false;
	   });

	</script>