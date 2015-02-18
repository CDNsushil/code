<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
	'name'=>'confirmBillingAddress',
	'id'=>'confirmBillingAddress'
);
$billing_firstName = isset($userProfileData->billing_firstName) ? $userProfileData->billing_firstName : '' ;
$billing_firstNameInput = array(
	'name'	=> 'billing_firstName',
	'id'	=> 'billing_firstName',
	'class'	=> 'width_551 required',
	'value'	=> set_value('billing_firstName')?set_value('billing_firstName'):$billing_firstName,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_lastName = isset($userProfileData->billing_lastName) ? $userProfileData->billing_lastName : '' ;
$billing_lastNameInput = array(
	'name'	=> 'billing_lastName',
	'id'	=> 'billing_lastName',
	'class'	=> 'width_551 required',
	'value'	=> set_value('billing_lastName')?set_value('billing_lastName'):$billing_lastName,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_city = isset($userProfileData->billing_city) ? $userProfileData->billing_city : '' ;
$billing_cityInput = array(
	'name'	=> 'billing_city',
	'id'	=> 'billing_city',
	'class'	=> 'width_551 required',
	'value'	=> set_value('billing_city')?set_value('billing_city'):$billing_city,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_address1 = isset($userProfileData->billing_address1) ? $userProfileData->billing_address1 : '' ;
$billing_address1Input = array(
	'name'	=> 'billing_address1',
	'id'	=> 'billing_address1',
	'class'	=> 'width_551 required',
	'value'	=> set_value('billing_address1')?set_value('billing_address1'):$billing_address1,
	'maxlength'	=> 100,
	'size'	=> 100
);
$billing_address2 = isset($userProfileData->billing_address2) ? $userProfileData->billing_address2 : '' ;
$billing_address2Input = array(
	'name'	=> 'billing_address2',
	'id'	=> 'billing_address2',
	'class'	=> 'width_551',
	'value'	=> set_value('billing_address2')?set_value('billing_address2'):$billing_address2,
	'maxlength'	=> 100,
	'size'	=> 100
);
$billing_state = isset($userProfileData->billing_state) ? $userProfileData->billing_state : '' ;
$billing_stateInput = array(
	'name'	=> 'billing_state',
	'id'	=> 'billing_state',
	'class'	=> 'width_551 required',
	'value'	=> set_value('billing_state')?set_value('billing_state'):$billing_state,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_zip = isset($userProfileData->billing_zip) ? $userProfileData->billing_zip : '' ;
$billing_zipInput = array(
	'name'	=> 'billing_zip',
	'id'	=> 'billing_zip',
	'class'	=> 'widht_248 required',
	'value'	=> set_value('billing_zip')?set_value('billing_zip'):$billing_zip,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_phone = isset($userProfileData->billing_phone) ? $userProfileData->billing_phone : '' ;
$billing_phoneInput = array(
	'name'	=> 'billing_phone',
	'id'	=> 'billing_phone',
	'class'	=> 'widht_248',
	'value'	=> set_value('billing_phone')?set_value('billing_phone'):$billing_phone,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_email = isset($userProfileData->billing_email) ? $userProfileData->billing_email : '' ;
$billing_emailInput = array(
	'name'	=> 'billing_email',
	'id'	=> 'billing_email',
	'class'	=> 'width_551 email required',
	'value'	=> set_value('billing_email')?set_value('billing_email'):$billing_email,
	'maxlength'	=> 50,
	'size'	=> 50
);


$buyerSettingsInput = array(
	'name'	=> 'buyerSettings',
	'type'	=> 'hidden',
	'id'	=> 'buyerSettings',
	'value'	=>'buyerSettings'
);
$EuVatIdentificationNumber = isset($userProfileData->EuVatIdentificationNumber) ? $userProfileData->EuVatIdentificationNumber : '' ;
$EuVatIdentificationNumberInput = array(
	'name'	=> 'EuVatIdentificationNumber',
	'id'	=> 'EuVatIdentificationNumber',
	'class'	=> 'widht_248',
	'value'	=> $EuVatIdentificationNumber,
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 50
);

//Shipping details input fields----------------------------
$shipping_firstName = isset($userProfileData->shipping_firstName) ? $userProfileData->shipping_firstName : '' ;
$shipping_firstNameInput = array(
	'name'	=> 'shipping_firstName',
	'id'	=> 'shipping_firstName',
	'class'	=> 'width_551 required',
	'value'	=> set_value('shipping_firstName')?set_value('shipping_firstName'):$shipping_firstName,
	'maxlength'	=> 50,
	'size'	=> 50
);
$shipping_lastName = isset($userProfileData->shipping_lastName) ? $userProfileData->shipping_lastName : '' ;
$shipping_lastNameInput = array(
	'name'	=> 'shipping_lastName',
	'id'	=> 'shipping_lastName',
	'class'	=> 'width_551 required',
	'value'	=> set_value('shipping_lastName')?set_value('shipping_lastName'):$shipping_lastName,
	'maxlength'	=> 50,
	'size'	=> 50
);
$shipping_city = isset($userProfileData->shipping_city) ? $userProfileData->shipping_city : '' ;
$shipping_cityInput = array(
	'name'	=> 'shipping_city',
	'id'	=> 'shipping_city',
	'class'	=> 'width_551 required',
	'value'	=> set_value('shipping_city')?set_value('shipping_city'):$shipping_city,
	'maxlength'	=> 50,
	'size'	=> 50
);
$shipping_address1 = isset($userProfileData->shipping_address1) ? $userProfileData->shipping_address1 : '' ;
$shipping_address1Input = array(
	'name'	=> 'shipping_address1',
	'id'	=> 'shipping_address1',
	'class'	=> 'width_551 required',
	'value'	=> set_value('shipping_address1')?set_value('shipping_address1'):$shipping_address1,
	'maxlength'	=> 100,
	'size'	=> 100
);
$shipping_address2 = isset($userProfileData->shipping_address2) ? $userProfileData->shipping_address2 : '' ;
$shipping_address2Input = array(
	'name'	=> 'shipping_address2',
	'id'	=> 'shipping_address2',
	'class'	=> 'width_551',
	'value'	=> set_value('shipping_address2')?set_value('shipping_address2'):$shipping_address2,
	'maxlength'	=> 100,
	'size'	=> 100
);
$shipping_state = isset($userProfileData->shipping_state) ? $userProfileData->shipping_state : '' ;
$shipping_stateInput = array(
	'name'	=> 'shipping_state',
	'id'	=> 'shipping_state',
	'class'	=> 'width_551 required',
	'value'	=> set_value('shipping_state')?set_value('shipping_state'):$shipping_state,
	'maxlength'	=> 50,
	'size'	=> 50
);
$shipping_zip = isset($userProfileData->shipping_zip) ? $userProfileData->shipping_zip : '' ;
$shipping_zipInput = array(
	'name'	=> 'shipping_zip',
	'id'	=> 'shipping_zip',
	'class'	=> 'widht_248 required',
	'value'	=> set_value('shipping_zip')?set_value('shipping_zip'):$shipping_zip,
	'maxlength'	=> 50,
	'size'	=> 50
);
$shipping_phone = isset($userProfileData->shipping_phone) ? $userProfileData->shipping_phone : '' ;
$shipping_phoneInput = array(
	'name'	=> 'shipping_phone',
	'id'	=> 'shipping_phone',
	'class'	=> 'widht_248',
	'value'	=> set_value('shipping_phone')?set_value('shipping_phone'):$shipping_phone,
	'maxlength'	=> 50,
	'size'	=> 50
);
$shipping_email = isset($userProfileData->shipping_email) ? $userProfileData->shipping_email : '' ;
$shipping_emailInput = array(
	'name'	=> 'shipping_email',
	'id'	=> 'shipping_email',
	'class'	=> 'width_551 email required',
	'value'	=> set_value('shipping_email')?set_value('shipping_email'):$shipping_email,
	'maxlength'	=> 50,
	'size'	=> 50
);


$shipping_buyerSettingsInput = array(
	'name'	=> 'shipping_buyerSettings',
	'type'	=> 'hidden',
	'id'	=> 'shipping_buyerSettings',
	'value'	=>'buyerSettings'
);
$shippingEuVatIdentificationNumber = isset($userProfileData->shippingEuVatIdentificationNumber) ? $userProfileData->shippingEuVatIdentificationNumber : '' ;
$shippingEuVatIdentificationNumberInput = array(
	'name'	=> 'shippingEuVatIdentificationNumber',
	'id'	=> 'shippingEuVatIdentificationNumber',
	'class'	=> 'widht_248 number',
	'value'	=> set_value('shippingEuVatIdentificationNumber')?set_value('shippingEuVatIdentificationNumber'):$shippingEuVatIdentificationNumber,
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 50
);

if(isset($userProfileData->countryGroup) && ($userProfileData->countryGroup=='EU')){
$class='';	
}else{
	$class='dn';
	}
	
?>

 <div>
          <div class="seprator_6"></div>
          <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern">
              <div class="cart_top_header_heading">Shopping Cart </div>
              <div class="cart_main_nav_box font_opensans">              
                
                <a class="ml40 selected">
                <div class="CMN_count">1</div>
                <div class="ml60 mt9 mr30 font_opensans">Confirm Billing Details</div>
                </a>                
               
                
                <a class="ml40">
                <div class="CMN_count">2</div>
                <div class="ml52 mt9 mr12">Confirm Purchase</div>
                </a>
                
                 <a class="ml40">
                <div class="CMN_count">3</div>
                <div class="ml60 mt9 mr30 font_opensans">Payment</div>
                </a>
                
                
                 </div>
              <div class="clear"></div>
            </div>
          </div>
          <div class="seprator_25"></div>
          <div class="cart_container_outer ">
          	<div class="cart_container third_party">
        <div class="seprator_15"></div>
					<div class="SCart_form_heading ml280 pt10"> Billing Details </div>
                    
                    	<div class="position_relative">
                        
                        <div class="cell shadow_wp strip_absolute_right left_236">
                <!-- <img src="images/strip_blog.png"  border="0"/>-->
                <table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
                  <tbody>
                    <tr>
                      <td height="271"><img src="<?php echo base_url('images/shadow-top.png')?>"></td>
                    </tr>
                    <tr>
                      <td class="shadow_mid">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="271"><img src="<?php echo base_url('images/shadow-bottom.png')?>"></td>
                    </tr>
                  </tbody>
                </table>
                <div class="clear"></div>
              </div>
 <?php     echo form_open(base_url(lang().'/cart/saveBillingDetails'),$formAttributes);  
			$validation_errors= validation_errors(); ?>
              <div class="seprator_20"></div>
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label class="req_field">First Name</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256">
                  <?php echo form_input($billing_firstNameInput); ?>
                </div>
              </div>
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label class="req_field">Last Name</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256 ">
                  <?php echo form_input($billing_lastNameInput); ?>
                </div>
              </div>
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256 ">
                  <label class="req_field">Address Line 1</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256">
                  <?php echo form_input($billing_address1Input); ?>
                </div>
              </div>
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label>Address Line 2</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256 ">
                 <?php echo form_input($billing_address2Input); ?>
                </div>
              </div>
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label class="req_field">Town or City</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256 ">
                 <?php echo form_input($billing_cityInput); ?>
                </div>
              </div>
              
               <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label class="req_field">Country</label>
                </div>
                <div class="cell join_frm_element_wrapper pl58 min_width256 confirmselect pr">                  
                  
                <?php 
                //class ="main_SELECT dn"
                    $billing_country = isset($userProfileData->billing_country) ? $userProfileData->billing_country : '' ;                   
					  $billing_country=set_value('billing_country')?set_value('billing_country'):$billing_country;
					  echo form_dropdown('billing_country', $countryList, $billing_country,'id="billing_country" class=" left56 required" onchange="generateStateList(\'billingState\',this.value,\'billing_state\',\'main_SELECT left56 \'); checkCountry();"');
				  
				  
				  ?>                                     
                </div>
             </div>
              
             <div class="row">
            <div class="Confirm-Billing_wrapper cell min_width256">
               <label>State, Province or Region</label>
            </div>
            <!--label_wrapper-->
           <div class=" cell join_frm_element_wrapper pl58 min_width256 confirmselect pr" id="billingState">
                    <?php 
                            $billing_country = ($billing_country!='')?$billing_country : 0;
                            $useBillingStae =  (isset($userProfileData->billing_state) && ($userProfileData->billing_state!=''))?$userProfileData->billing_state : 0;
                            $stateList = getStatesList($billing_country,true);                                                    
							$billing_state=$useBillingStae;
							$billing_state=set_value('billing_state')?set_value('billing_state'):$billing_state;
							echo form_dropdown('billing_state', $stateList, $billing_state,'class="main_SELECT dn left56 required"');
					  ?>
                </div>
          </div>
              
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label class="req_field">Zip or Post Code</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256">
                 <?php echo form_input($billing_zipInput); ?>
                </div>
              </div>
                       
             
             	<div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label class="req_field">Email Address</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256">
                  <?php echo form_input($billing_emailInput); ?>
                </div>
              </div>
              
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label>Phone Number</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256">
                   <?php echo form_input($billing_phoneInput); ?>
                </div>
              </div>
              
               <div class="row EuVat <?php echo $class ?>">
                <div class="Confirm-Billing_wrapper cell min_width256">
                  <label>EU VAT Number</label>
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256">
                 <?php echo form_input($EuVatIdentificationNumberInput); ?>
                </div>
              </div> 
              
              <div class="row pt10 EuVatMsg">
                <div class="Confirm-Billing_wrapper cell min_width256">                
                </div>
                <div class=" cell join_frm_element_wrapper pl58 min_width256">
                   <div class="font_opensansSBold font_size11 mt2  width_577 Fleft">* If you need a Tax/Business Registration Number to appear on your Sales Records, let us know in <br/> &nbsp;&nbsp; <a class="center_content underline font_size11 hoverOrange" target="blank" href="<?php echo base_url(lang().'/dashboard/globalsettings')?>">Buyer Settings</a>. </div>  
                </div>
              </div>
            
              <?php if(isset($globelBilling) && ($globelBilling!='')) {
				  $checked = '';				  
			  }else{
				  $checked = 'checked="checked"';
				  } ?>
              
              <div class="clear"> </div>
              <div class="seprator_20"></div>
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256"> </div>
                <div class=" cell pl58 min_width256">
                  <div class="defaultP">
                    <input type="checkbox" name="billingsaveglobalSettings" id="banana" value="1" <?php echo $checked ?>  />
                  </div>
                  <span class="display_inline font_opensans">Save in Global Settings.</span> </div>
              </div>
              <div class="clear"> </div>
              <div class="seprator_8"></div>
                
               <div>
                <div class="dotdivider Fleft width_562 ml280"> </div>
              </div>  
                                   
             <div class="clear"></div>
              <div class="seprator_15"> </div>
            
            <!---------------------------- Shipping Form ----------------------------------------->
            <?php
            if($isShippingDetails){?>
            
						<div class="SCart_form_heading ml280 pt10  "> Shipping Details </div>
						
						<div class="clear"></div>
						<div class="seprator_25"> </div> 

						<div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256"> </div>
							<div class=" cell pl58 min_width256">
							<div class="defaultP" id="show_shippingform">
							<input type="checkbox" value="1" name="shipping_isSameAsBilling" class="ez-hide">      
							</div>
							<span class="display_inline font_opensans">Same as Billing Address</span> </div>
						</div>   
						
						<div class="toggle"> 
			 
						  <div class="seprator_20"></div>
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256">
							  <label class="req_field">First Name</label>
							</div>
							<div class=" cell join_frm_element_wrapper pl58 min_width256">
							  <?php echo form_input($shipping_firstNameInput); ?>
							</div>
						  </div>
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256">
							  <label class="req_field">Last Name</label>
							</div>
							<div class=" cell join_frm_element_wrapper pl58 min_width256 ">
							  <?php echo form_input($shipping_lastNameInput); ?>
							</div>
						  </div>
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256 ">
							  <label class="req_field">Address Line 1</label>
							</div>
							<div class=" cell join_frm_element_wrapper pl58 min_width256">
							  <?php echo form_input($shipping_address1Input); ?>
							</div>
						  </div>
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256">
							  <label>Address Line 2</label>
							</div>
							<div class=" cell join_frm_element_wrapper pl58 min_width256 ">
							 <?php echo form_input($shipping_address2Input); ?>
							</div>
						  </div>
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256">
							  <label class="req_field">Town or City</label>
							</div>
							<div class=" cell join_frm_element_wrapper pl58 min_width256 ">
							 <?php echo form_input($shipping_cityInput); ?>
							</div>
						  </div>
						  
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256">
							  <label class="req_field">Country</label>
							</div>
							<div class="cell join_frm_element_wrapper pl58 min_width256 confirmselect pr">                  
							  
							<?php 
							//class="main_SELECT dn"
								  $shipping_country = isset($userProfileData->shipping_country) ? $userProfileData->shipping_country : '' ;                   
								  $shipping_country=set_value('shipping_country')?set_value('shipping_country'):$shipping_country;
								  echo form_dropdown('shipping_country', $countryList, $shipping_country,'id="shipping_country" class="left56 "required error" onchange="generateStateList(\'shippingState\',this.value,\'shipping_state\',\'main_SELECT left56 \');"');
							  ?>   
												
							</div>
						 </div>
						 
						  <div class="row">
						<div class="Confirm-Billing_wrapper cell min_width256">
						   <label>State, Province or Region</label>
						</div>
						<!--label_wrapper-->
					   <div class=" cell join_frm_element_wrapper pl58 min_width256 confirmselect pr" id="shippingState">
								<?php                     
										$shipping_country = ($shipping_country!='')?$shipping_country : 0;
										$useShippingState =  (isset($userProfileData->shipping_state) && ($userProfileData->shipping_state!=''))?$userProfileData->shipping_state : 0;
								
										$stateList = getStatesList($shipping_country,true);                                                    
										$shipping_state=$useShippingState ;
										$shipping_state=set_value('shipping_state')?set_value('shipping_state'):$shipping_state;
										echo form_dropdown('shipping_state', $stateList, $shipping_state,'class="main_SELECT dn left56 "');
								  ?>
							</div>
					  </div>
						 
						  
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256">
							  <label class="req_field">Zip or Post Code</label>
							</div>
							<div class=" cell join_frm_element_wrapper pl58 min_width256">
							 <?php echo form_input($shipping_zipInput); ?>
							</div>
						  </div>             
						  
							<div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256">
							  <label class="req_field">Email Address</label>
							</div>
							<div class=" cell join_frm_element_wrapper pl58 min_width256">
							  <?php echo form_input($shipping_emailInput); ?>
							</div>
						  </div>
						  
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256">
							  <label>Phone Number</label>
							</div>
							<div class=" cell join_frm_element_wrapper pl58 min_width256">
							   <?php echo form_input($shipping_phoneInput); ?>
							</div>
						  </div>
						  
						   
						  <?php if(isset($globelShipping) && ($globelShipping!='')) {
							  $checked = '';				  
						  }else{
							  $checked = 'checked="checked"';
							  } ?>
						  
						  <div class="clear"> </div>
						  <div class="seprator_20"></div>
						  <div class="row">
							<div class="Confirm-Billing_wrapper cell min_width256"> </div>
							<div class=" cell pl58 min_width256">
							  <div class="defaultP">
								<input type="checkbox" name="shippingsaveglobalSettings" id="shippingbanana" value="1" <?php echo $checked ?> />
							  </div>
							  <span class="display_inline font_opensans">Save in Global Settings.</span> </div>
						  </div>
						  <div class="clear"> </div>
						  <div class="seprator_8"></div>
						  
						  </div>
						  
              
              <div>
                <div class="dotdivider Fleft width_562 ml280"> </div>
              </div>
              <div class="seprator_24"></div>
           <?php
	   }
	   ?>
              
              <div class="row">
                <div class="Confirm-Billing_wrapper cell min_width256 height8"> </div>
                <div class=" cell join_frm_element_wrapper pl58 width_562">
                  <div class="Req_fld font_opensansSBold font_size12 mt2 Fleft"> Required Fields</div>
                  <div class="clear"></div>
                   <div class="font_opensansSBold font_size11 mt2 Fleft">* These fields need to be filled in  before you can buy.</div>
                   <div class="font_opensansSBold font_size11 mt2 Fleft width_577 dn">*  You need a PayPal account to buy from third-party Sellers.</div>
                    <div class="font_opensansSBold font_size11 mt2 Fleft width_577">* Consumption Tax (VAT, GST, Sales Tax etc.) will be added, if applicable, as you checkout.</div>
                    <div class="font_opensansSBold font_size11 mt2 Fleft width_577">* The Shipping Charge, set by the Seller, will be added to the Product price as you checkout.</div>
                </div>
                <div class="clear"></div>
                <div class="seprator_10"></div>
              </div>

              
            </div>
            
             <!------ Shipping Form ----->
            <div>
				
			<input type="hidden" name="save" value='1' />	
            <div class="tds-button-orange Fright mr10"> 			  
			  <a  onclick="checkout();" onmouseup="mouseup_tds_button_orange(this)" onmousedown="mousedown_tds_button_orange(this)"><span class=" font_OpenSansBold width_90">CHECKOUT</span></a> </div>	
            </div>
          <div class="clear"></div>  
          <div class="seprator_10"></div>
            </div> <!-- /cart_container -->
          </div>
   <?php echo form_close(); ?>        
          <div class="seprator_20"></div>
        </div>

<script>
$(document).ready(function(){
	$("#confirmBillingAddress").validate();
});

function checkout(){      
	$("#confirmBillingAddress").submit();	
 }
	 
function mousedown_tds_button_orange(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button_orange(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}	 
	 
function checkCountry()
{
	var countryId = $("#billing_country").val();		
	$.ajax
		({     
		   type: "POST",
		   url: "<?php echo base_url() ?>membershipcart/checkBillingCountry/"+countryId,

			success: function(msg)
			{  
				if(msg==true){					
					$('.EuVat').removeClass('dn');
					// $('.EuVatMsg').removeClass('dn');
					//$('#EuVatIdentificationNumber').val(' ');
					//$('#EuVatIdentificationNumber').val('0');
					} else {
						  $('.EuVat').addClass('dn');
						  // $('.EuVatMsg').addClass('dn');
						  
						}
				
		     }
	});	
	
	}	 

$("#show_shippingform").click(function(){
  	$(".toggle").toggle();
	
  							  
  });	 

</script>
