<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$cartId=$this->session->userdata('currentCartId');


if($cartId==''){	
	redirect(base_url(lang().'/membershipcart/buyspace'));	
	}



$formAttributes = array(
	'name'=>'confirmBilling',
	'id'=>'confirmBilling'
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
	'value'	=> set_value('EuVatIdentificationNumber')?set_value('EuVatIdentificationNumber'):$EuVatIdentificationNumber,
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 50
);


$cartId=$this->session->userdata('currentCartId'); 

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
              <div class="cart_top_header_heading"> <?php echo $this->lang->line('membershipcart'); ?></div>
              <div class="cart_main_nav_box font_opensans">
               <a class=" ml40">
                <div class="CMN_count">1</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('choosespace'); ?></div>
                </a> 
                
                <a class="ml40 selected">
                <div class="CMN_count">2</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('confirmbilling'); ?></div>
                </a> 
                
                <a class="ml40">
                <div class="CMN_count">3</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('summary'); ?></div>
                </a>
                
                <!-- <a class="ml40">
                <div class="CMN_count">4</div>
                <div class="ml52 mt9 mr12">Confirm Purchase</div>
                </a>-->
                
                 <a class="ml40">
                <div class="CMN_count">4</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('payment'); ?></div>
                </a>
                
                
                 </div>
              <div class="clear"></div>
            </div>
          </div>
          <div class="seprator_25"></div>
          <div class="cart_container_outer ">
          	<div class="cart_container min_h558 pl30 pr30 pr30 pt20 pb20">
<div class="seprator_15"></div>
					<div class="SCart_form_heading ml250 pt10 "> <?php echo $this->lang->line('billingdetail'); ?> </div>
                    
                    	<div class="position_relative">
                        
                        <div class="cell shadow_wp strip_absolute_right mt-26 left_204">
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
 <?php     echo form_open(base_url(lang().'/membershipcart/saveBillingData'),$formAttributes);  
			$validation_errors= validation_errors(); ?>
              <div class="seprator_20"></div>
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper minW_190 cell">
                  <label class="req_field"> <?php echo $this->lang->line('FirstName'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58">
                  <?php echo form_input($billing_firstNameInput); ?>
                </div>
              </div>
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label class="req_field"><?php echo $this->lang->line('LastName'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58 ">
                  <?php echo form_input($billing_lastNameInput); ?>
                </div>
              </div>
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell ">
                  <label class="req_field"> <?php echo $this->lang->line('AddressLine1'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58">
                  <?php echo form_input($billing_address1Input); ?>
                </div>
              </div>
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label> <?php echo $this->lang->line('AddressLine2'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58 ">
                 <?php echo form_input($billing_address2Input); ?>
                </div>
              </div>
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label class="req_field"> <?php echo $this->lang->line('TownorCity'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58 ">
                 <?php echo form_input($billing_cityInput); ?>
                </div>
              </div>
              
            <div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label class="req_field"><?php echo $this->lang->line('Country'); ?></label>
                </div>
                <div class="cell join_frm_element_wrapper width_540 pl58 confirmselect pr">                  
                  
                <?php 
                      $billing_country = isset($userProfileData->billing_country) ? $userProfileData->billing_country : '' ;                   
					  $billing_country=set_value('billing_country')?set_value('billing_country'):$billing_country;
					  echo form_dropdown('billing_country', $countryList, $billing_country,'id="billing_country" class="required left56" onchange="generateStateList(\'billingState\',this.value,\'billing_state\',\'main_SELECT left56 \'); checkCountry();"');
				  ?>   
                                    
                </div>
             </div>
              
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label class="req_field"> <?php echo $this->lang->line('StateProvinceorRegion'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58" id="billingState">
                 <?php 
							$billing_country = isset($userProfileData->billing_country) ? $userProfileData->billing_country : '' ; 
                            $billing_country = ($billing_country!='')?$billing_country : 0;
                            $useBillingStae =  (isset($userProfileData->billing_state) && ($userProfileData->billing_state!=''))?$userProfileData->billing_state : 0;
                            $stateList = getStatesList($billing_country,true);                                                    
							$billing_state=$useBillingStae;
							$billing_state=set_value('billing_state')?set_value('billing_state'):$billing_state;
							echo form_dropdown('billing_state', $stateList, $billing_state,'class="main_SELECT dn left56"');
					  ?>
                </div>
              </div>
              
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label class="req_field"><?php echo $this->lang->line('ZiporPostCode'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58">
                 <?php echo form_input($billing_zipInput); ?>
                </div>
              </div>
              
              
              
             
             	<div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label class="req_field"><?php echo $this->lang->line('EmailAddress'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58">
                  <?php echo form_input($billing_emailInput); ?>
                </div>
              </div>
              
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label><?php echo $this->lang->line('PhoneNumber'); ?></label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58">
                   <?php echo form_input($billing_phoneInput); ?>
                </div>
              </div>
              
               <div class="row EuVat <?php echo $class ?>">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">
                  <label>EU VAT Number</label>
                </div>
                <div class=" cell join_frm_element_wrapper width_540 pl58">
                 <?php echo form_input($EuVatIdentificationNumberInput); ?>
                </div>
              </div>
              
              <div class="row pt10 EuVatMsg">
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell">                
                </div>
                <div class="cell join_frm_element_wrapper pl58 min_width256">
                   <div class="font_opensansSBold font_size11 mt2  width_577 Fleft">* If you need a Tax/Business Registration Number to appear on your Sales Records, let us know in <br/> &nbsp;&nbsp; <a class=" hoverOrange center_content underline font_size11" target="blank" href="<?php echo base_url(lang().'/dashboard/globalsettings')?>">Buyer Settings</a>. </div>  
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
                <div class="stage_Confirm-Billing_wrapper  minW_190 cell"> </div>
                <div class=" cell pl58 min_width256">
                  <div class="defaultP">
                    <input type="checkbox" name="saveglobalSettings" id="banana" value="1" <?php echo $checked ?>  />
                  </div>
                  <span class="display_inline font_opensans"><?php echo $this->lang->line('SaveinGlobalSettings'); ?></span> </div>
              </div>
              <div class="clear"> </div>
              <div class="seprator_8"></div>
              
              <div class="row">
                <div class="stage_Confirm-Billing_wrapper minW_190 cell height8"> </div>
                <div class=" cell join_frm_element_wrapper pl58 width_562">
                  <div class="Req_fld font_opensansSBold font_size12 mt2 Fleft"> <?php echo $this->lang->line('RequiredFields'); ?></div>
                  <div class="clear"></div>
                   <div class="font_opensansSBold font_size11 mt2 Fleft">* <?php echo $this->lang->line('Theseneedfilled'); ?></div>                   
                   <div class="font_opensansSBold font_size11 mt2 Fleft">* VAT will be added, if applicable, as you checkout.</div>
                </div>
                <div class="clear"></div>
              </div>

              
            </div>
            <!-- / Relative -->
            <div class="seprator_40"></div>
            <div>
				
				
            <div class="tds-button-orange Fright mr10"> 
            
				  
			<a  onclick="saveForm();" onmouseup="mouseup_tds_button_orange(this)" onmousedown="mousedown_tds_button_orange(this)"><span class=" font_OpenSansBold width_90"><?php echo $this->lang->line('CONTINUE'); ?></span></a> </div>	  
				  
            
          
            
            </div>
            
            </div> <!-- /cart_container -->
          </div>
   <?php echo form_close(); ?>        
          <div class="seprator_20"></div>
        </div>

<script>
$(document).ready(function(){
	$("#confirmBilling").validate();
});


 function saveForm(){	 
	  $('#confirmBilling').submit();	 
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
					//$('#EuVatIdentificationNumber').val('0');
					} else {
						  $('.EuVat').addClass('dn');
						}
				
		     }
	});	 
	
		
	
	}	 
	 

</script>
