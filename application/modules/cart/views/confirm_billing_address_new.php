<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
	'name'=>'confirmBillingAddress',
	'id'=>'confirmBillingAddress'
);
$billing_firstName = isset($userProfileData->billing_firstName) ? $userProfileData->billing_firstName : '' ;
$billing_firstNameInput = array(
	'name'	=> 'billing_firstName',
	'id'	=> 'billing_firstName',
	'class'	=> 'font_wN required',
    'onblur'=> "placeHoderHideShow(this,'First name *','show')",
    'onclick'=> "placeHoderHideShow(this,'First name *','hide')",
    'placeholder'     =>  "First Name *",
	'value'	=> set_value('billing_firstName')?set_value('billing_firstName'):$billing_firstName,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_lastName = isset($userProfileData->billing_lastName) ? $userProfileData->billing_lastName : '' ;
$billing_lastNameInput = array(
	'name'	=> 'billing_lastName',
	'id'	=> 'billing_lastName',
	'class'	=> 'font_wN required',
    'onblur'=> "placeHoderHideShow(this,'Last name *','show')",
    'onclick'=> "placeHoderHideShow(this,'Last name *','hide')",
    'placeholder'     =>  "Last Name *",
	'value'	=> set_value('billing_lastName')?set_value('billing_lastName'):$billing_lastName,
	'maxlength'	=> 50,
	'size'	=> 50
);

$billing_companyName = isset($userProfileData->billing_companyName) ? $userProfileData->billing_companyName : '' ;
$billing_companyNameInput = array(
	'name'	=> 'billing_companyName',
	'id'	=> 'billing_companyName',
	'class'	=> 'font_wN required',
    'onblur'=> "placeHoderHideShow(this,'Company Name *','show')",
    'onclick'=> "placeHoderHideShow(this,'Company Name *','hide')",
    'placeholder'     =>  "Company Name *",
	'value'	=> set_value('billing_companyName')?set_value('billing_companyName'):$billing_companyName,
	'maxlength'	=> 50,
	'size'	=> 50
);

$billing_city = isset($userProfileData->billing_city) ? $userProfileData->billing_city : '' ;
$billing_cityInput = array(
	'name'	=> 'billing_city',
	'id'	=> 'billing_city',
	'class'	=> 'font_wN required',
    'onblur'=> "placeHoderHideShow(this,'Town or City *','show')",
    'onclick'=> "placeHoderHideShow(this,'Town or City *','hide')",
    'placeholder'     =>  "Town or City *",
	'value'	=> set_value('billing_city')?set_value('billing_city'):$billing_city,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_address1 = isset($userProfileData->billing_address1) ? $userProfileData->billing_address1 : '' ;
$billing_address1Input = array(
	'name'	=> 'billing_address1',
	'id'	=> 'billing_address1',
	'class'	=> 'font_wN required',
    'onblur'=> "placeHoderHideShow(this,'Billing address *','show')",
    'onclick'=> "placeHoderHideShow(this,'Billing address *','hide')",
    'placeholder'     =>  "Billing address *",
	'value'	=> set_value('billing_address1')?set_value('billing_address1'):$billing_address1,
	'maxlength'	=> 100,
	'size'	=> 100
);
$billing_address2 = isset($userProfileData->billing_address2) ? $userProfileData->billing_address2 : '' ;
$billing_address2Input = array(
	'name'	=> 'billing_address2',
	'id'	=> 'billing_address2',
	'class'	=> 'font_wN',
    'onblur'=> "placeHoderHideShow(this,'Billing address2','show')",
    'onclick'=> "placeHoderHideShow(this,'Billing address2','hide')",
    'placeholder'     =>  "Billing address2",
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
	'class'	=> 'font_wN width_160 required',
    'onblur'=> "placeHoderHideShow(this,'Post Code or ZIP Code *','show')",
    'onclick'=> "placeHoderHideShow(this,'Post Code or ZIP Code *','hide')",
    'placeholder'     =>  "Post Code or ZIP Code *",
	'value'	=> set_value('billing_zip')?set_value('billing_zip'):$billing_zip,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_phone = isset($userProfileData->billing_phone) ? $userProfileData->billing_phone : '' ;
$billing_phoneInput = array(
	'name'	=> 'billing_phone',
	'id'	=> 'billing_phone',
	'class'	=> 'font_wN',
    'onblur'=> "placeHoderHideShow(this,'Phone Number','show')",
    'onclick'=> "placeHoderHideShow(this,'Phone Number','hide')",
    'placeholder'     =>  "Phone Number",
	'value'	=> set_value('billing_phone')?set_value('billing_phone'):$billing_phone,
	'maxlength'	=> 50,
	'size'	=> 50
);
$billing_email = isset($userProfileData->billing_email) ? $userProfileData->billing_email : '' ;
$billing_emailInput = array(
	'name'	=> 'billing_email',
	'id'	=> 'billing_email',
	'class'	=> 'font_wN email required',
    'onblur'=> "placeHoderHideShow(this,'Email Address *','show')",
    'onclick'=> "placeHoderHideShow(this,'Email Address *','hide')",
    'placeholder'     =>  "Email Address *",
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
	'class'	=> 'font_wN',
	'value'	=> $EuVatIdentificationNumber,
    'onblur'=> "placeHoderHideShow(this,'Eu Vat Identification Number *','show')",
    'onclick'=> "placeHoderHideShow(this,'Eu Vat Identification Number','hide')",
    'placeholder'     =>  "Eu Vat Identification Number",
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 50
);

//Shipping details input fields----------------------------
$shipping_firstName = isset($userProfileData->shipping_firstName) ? $userProfileData->shipping_firstName : '' ;
$shipping_firstNameInput = array(
	'name'	=> 'shipping_firstName',
	'id'	=> 'shipping_firstName',
	'class'	=> 'font_wN required',
	'value'	=> set_value('shipping_firstName')?set_value('shipping_firstName'):$shipping_firstName,
	'maxlength'	=> 50,
    'onclick'         =>  "placeHoderHideShow(this,'First name*','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'First name*','show')",
    'placeholder'     =>  "First name*",
	'size'	=> 50
);
$shipping_lastName = isset($userProfileData->shipping_lastName) ? $userProfileData->shipping_lastName : '' ;
$shipping_lastNameInput = array(
	'name'	=> 'shipping_lastName',
	'id'	=> 'shipping_lastName',
	'class'	=> 'font_wN required',
	'value'	=> set_value('shipping_lastName')?set_value('shipping_lastName'):$shipping_lastName,
	'maxlength'	=> 50,
    'onclick'         =>  "placeHoderHideShow(this,'Last name*','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Last name*','show')",
    'placeholder'     => "Last name*",
	'size'	=> 50
);

$shipping_companyName = isset($userProfileData->shipping_companyName) ? $userProfileData->shipping_companyName : '' ;
$shipping_companyNameInput = array(
	'name'	=> 'shipping_companyName',
	'id'	=> 'shipping_companyName',
	'class'	=> 'font_wN required',
	'value'	=> set_value('shipping_companyName')?set_value('shipping_companyName'):$shipping_companyName,
	'maxlength'	=> 50,
    'onclick'         =>  "placeHoderHideShow(this,'Company Name*','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Company Name*','show')",
    'placeholder'     =>  "Company Name*",
	'size'	=> 50
);

$shipping_city = isset($userProfileData->shipping_city) ? $userProfileData->shipping_city : '' ;
$shipping_cityInput = array(
	'name'	=> 'shipping_city',
	'id'	=> 'shipping_city',
	'class'	=> 'font_wN required',
	'value'	=> set_value('shipping_city')?set_value('shipping_city'):$shipping_city,
	'maxlength'	=> 50,
    'onclick'         =>  "placeHoderHideShow(this,'Town or City*','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Town or City*','show')",
    'placeholder'     =>  "Town or City*",
	'size'	=> 50
);
$shipping_address1 = isset($userProfileData->shipping_address1) ? $userProfileData->shipping_address1 : '' ;
$shipping_address1Input = array(
	'name'	=> 'shipping_address1',
	'id'	=> 'shipping_address1',
	'class'	=> 'font_wN required',
	'value'	=> set_value('shipping_address1')?set_value('shipping_address1'):$shipping_address1,
	'maxlength'	=> 100,
    'onclick'         =>  "placeHoderHideShow(this,'Address Line 1*','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Address Line 1*','show')",
    'placeholder'     =>  "Address Line 1*",
	'size'	=> 100
);
$shipping_address2 = isset($userProfileData->shipping_address2) ? $userProfileData->shipping_address2 : '' ;
$shipping_address2Input = array(
	'name'	=> 'shipping_address2',
	'id'	=> 'shipping_address2',
	'class'	=> 'font_wN',
	'value'	=> set_value('shipping_address2')?set_value('shipping_address2'):$shipping_address2,
	'maxlength'	=> 100,
    'onclick'         =>  "placeHoderHideShow(this,'Address Line 2','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Address Line 2','show')",
    'placeholder'     =>  "Address Line 2",
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
	'class'	=> 'font_wN width_160 required',
	'value'	=> set_value('shipping_zip')?set_value('shipping_zip'):$shipping_zip,
	'maxlength'	=> 50,
    'onclick'         =>  "placeHoderHideShow(this,'Post Code or ZIP Code*','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Post Code or ZIP Code*','show')",
    'placeholder'     =>  "Post Code or ZIP Code*",
	'size'	=> 50
);
$shipping_phone = isset($userProfileData->shipping_phone) ? $userProfileData->shipping_phone : '' ;
$shipping_phoneInput = array(
	'name'	=> 'shipping_phone',
	'id'	=> 'shipping_phone',
	'class'	=> 'font_wN',
	'value'	=> set_value('shipping_phone')?set_value('shipping_phone'):$shipping_phone,
	'maxlength'	=> 50,
    'onclick'         =>  "placeHoderHideShow(this,'Phone Number','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Phone Number','show')",
    'placeholder'     =>  "Phone Number",
	'size'	=> 50
);
$shipping_email = isset($userProfileData->shipping_email) ? $userProfileData->shipping_email : '' ;
$shipping_emailInput = array(
	'name'	=> 'shipping_email',
	'id'	=> 'shipping_email',
	'class'	=> 'font_wN email required',
	'value'	=> set_value('shipping_email')?set_value('shipping_email'):$shipping_email,
	'maxlength'	=> 50,
    'onclick'         =>  "placeHoderHideShow(this,'Email Address*','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Email Address*','show')",
    'placeholder'     => "Email Address*",
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


<div class="blog_wrap">
   <div id="TabbedPanels1" class="TabbedPanels">
        <?php 
            //---------shopping cart progress bar steps----------//
                $this->load->view('common_view/shoppingcart_steps');
            //---------shopping cart progress bar steps----------//
        ?>
        <?php     
            echo form_open(base_url(lang().'/cart/postshoppingcartbilling'),$formAttributes);  
            $validation_errors= validation_errors(); 
        ?>
            <div class="TabbedPanelsContentGroup ">
         <!--=============================== Your Detail =============================-->
         <div class="TabbedPanelsContent TabbedPanelsContentVisible">
            <div class="wra_head clearb">
               <h3 class="red   fs21 fnt_mouse bb_aeaeae"> Billing Details </h3>
               <div class="sap_30"></div>
               <ul class=" billing_form form2" >
                    <li>
                        <?php echo form_input($billing_firstNameInput); ?>
                    </li>
                    <li>
                       <?php echo form_input($billing_lastNameInput); ?>
                    </li>
                    <li>
                        <?php echo form_input($billing_companyNameInput); ?>
                    </li>
                    <li>
                        <?php echo form_input($billing_address1Input); ?>
                    </li>
                    <li>
                       <?php echo form_input($billing_address2Input); ?>
                    </li>
                    <li>
                       <?php echo form_input($billing_cityInput); ?>
                    </li>
                 
                  <li class=" width_258 select select_1">
                    <?php 
                        //class ="main_SELECT dn"
                        $billing_country = isset($userProfileData->billing_country) ? $userProfileData->billing_country : '' ;                   
                        $billing_country=set_value('billing_country')?set_value('billing_country'):$billing_country;
                        echo form_dropdown('billing_country', $countryList, $billing_country,'id="billing_country" class=" left56 required" onchange="generateStateList(\'billingState\',this.value,\'billing_state\',\'main_SELECT left56 \'); checkCountry();"');
                    ?>   
                  </li>
                  <li class=" width_258 select select_2" id="billingState">
                    <?php 
                        $billing_country = ($billing_country!='')?$billing_country : 0;
                        $useBillingStae =  (isset($userProfileData->billing_state) && ($userProfileData->billing_state!=''))?$userProfileData->billing_state : 0;
                        $stateList = getStatesList($billing_country,true);                                                    
                        $billing_state=$useBillingStae;
                        $billing_state=set_value('billing_state')?set_value('billing_state'):$billing_state;
                        echo form_dropdown('billing_state', $stateList, $billing_state,'class="main_SELECT dn left56 required"');
                    ?>
                  </li>
                  <li class="width_190">
                        <?php echo form_input($billing_zipInput); ?>
                  </li>
                  <li>
                        <?php echo form_input($billing_phoneInput); ?>
                  </li>
                  <li>
                        <?php echo form_input($billing_emailInput); ?>
                  </li>
                  <li class="EuVat <?php echo $class ?>">
                        <?php echo form_input($EuVatIdentificationNumberInput); ?>
                  </li>
               </ul>
                <?php
                     if(isset($globelBilling) && ($globelBilling !='')) {
                       
                       $checked = 'checked="checked"';				  
                    }else{
                         $checked = '';
                    }
                    
                    /* check same both shipping and billing detail */
                    if(isset($globelBothShipping) && ($globelBothShipping !='')) {
                       
                       $checkedsameboth = 'checked="checked"';				  
                    }else{
                         $checkedsameboth = '';
                    }
                    
                ?>
                <ul class="billing_form form1">
                    <li class="bdr_non mt25">
                        <label class="pl5 fshel_midum defaultP lineH20 fl">
                             <input  class="ez-hide width_auto"  type="checkbox" name="billingsaveglobalSettings" id="banana" value="1" <?php echo $checked ?>  />
                            <?php echo $this->lang->line('saveInBilling');?>  
                            <a href="<?php echo base_url(lang().'/dashboard/globalsettings/3');?>"><?php echo $this->lang->line('globalSetting');?></a>
                        </label>
                    </li>
                </ul>
            </div>
           
            <!--------shipping details------->
             <?php   if($isShippingDetails){ ?>
                 <div class="wra_head clearb">
                  
                   <h3 class="red   fs21 fnt_mouse bb_aeaeae"> Shipping Details </h3>
                   <div class="sap_30"></div>
                       <div class=" display_inline_block defaultP">
                            <label><div class="ez-checkbox ez-checked">
                                <input type="checkbox" name="shipping_isSameAsBilling"  class="ez-hide" id="sameasbilling" value="1" <?php echo $checkedsameboth ?>  />
                                </div>
                                Same as Billing Address
                            </label>
                       </div>
                   <div class="sap_30"></div>
                   
                       <div class="shippingdetails">
                           <ul class=" billing_form form2" >
                              <li>
                                 <?php echo form_input($shipping_firstNameInput); ?>
                              </li>
                              <li>
                                 <?php echo form_input($shipping_lastNameInput); ?>
                              </li>
                              <li>
                                 <?php echo form_input($shipping_companyNameInput); ?>
                               </li>
                              <li>
                                 <?php echo form_input($shipping_address1Input); ?>
                              </li>
                              <li>
                                 <?php echo form_input($shipping_address2Input); ?>
                              </li>
                              <li>
                                 <?php echo form_input($shipping_cityInput); ?>
                              </li>
                              <li class=" width_258 select select_1">
                                <?php 
                                    //class="main_SELECT dn"
                                    $shipping_country = isset($userProfileData->shipping_country) ? $userProfileData->shipping_country : '' ;                   
                                    $shipping_country=set_value('shipping_country')?set_value('shipping_country'):$shipping_country;
                                    echo form_dropdown('shipping_country', $countryList, $shipping_country,'id="shipping_country" class="left56 "required error" onchange="generateStateList(\'shippingState\',this.value,\'shipping_state\',\'main_SELECT left56 \');"');
                                ?>   
                              </li>
                              <li class=" width_258 select select_2" id="shippingState">
                                <?php                     
                                    $shipping_country = ($shipping_country!='')?$shipping_country : 0;
                                    $useShippingState =  (isset($userProfileData->shipping_state) && ($userProfileData->shipping_state!=''))?$userProfileData->shipping_state : 0;

                                    $stateList = getStatesList($shipping_country,true);                                                    
                                    $shipping_state=$useShippingState ;
                                    $shipping_state=set_value('shipping_state')?set_value('shipping_state'):$shipping_state;
                                    echo form_dropdown('shipping_state', $stateList, $shipping_state,'class="main_SELECT dn left56 "');
                                ?>
                              </li>
                              <li class="width_190">
                                    <?php echo form_input($shipping_zipInput); ?>
                              </li>
                              <li>
                                    <?php echo form_input($shipping_phoneInput); ?>
                              </li>
                              <li>
                                    <?php echo form_input($shipping_emailInput); ?>
                              </li>
                           </ul>
                           
                            <?php 
                                if(isset($globelShipping) && ($globelShipping!='')) {
                                    $checked = 'checked="checked"';				  
                                }else{
                                    $checked = '';
                                } 
                            ?>
                           <ul class="billing_form form1">
                                <li class="bdr_non mt25">
                                    <label class="pl5 fshel_midum defaultP lineH20 fl">
                                        <input type="checkbox" class="ez-hide width_auto" name="shippingsaveglobalSettings" id="shippingbanana" value="1" <?php echo $checked ?> />
                                        <?php echo $this->lang->line('saveInShipping');?>  
                                        <a href="<?php echo base_url(lang().'/dashboard/globalsettings/3');?>"><?php echo $this->lang->line('globalSetting');?></a>
                                    </label>
                                </li>
                            </ul>
                       </div>
                   
                </div>
           
            <?php   }  ?>
           
            <div class="fr btn_wrap display_block font_weight">
                
                <a href="<?php echo base_url_lang(); ?>">
                   <button type="button" class="bg_ededed bdr_b1b1b1 mr5">Cancel</button>
                </a>
                <!--
                   <a href="JoinStage4-MembershipCart_annual.html">   <button class=" back  bdr_b1b1b1 mr5 back_click32" >Back </button></a>
                -->
                 <button onclick="checkout();" name="save" type="submit" class="b_F1592A next_click32 bdr_F1592A"> Next </button>
            </div>
         </div>
      
           
      </div>
        
        <?php echo form_close(); ?>        
   </div>
</div>


<script>
$(document).ready(function(){
    $("#confirmBillingAddress").validate();
});

function checkout(){      
    $("#confirmBillingAddress").submit();	
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

    //----------same as billing details-----------//
    $("#sameasbilling").click(function(){
        if($(this).is(':checked')){
             $(".shippingdetails").hide();
        }else{
             $(".shippingdetails").show();
        }    
    });	 
    
    // use do hide shipping detail data when its same as billing detail and checkbox is ticked
    
    if($('#sameasbilling').is(':checked')){
             $(".shippingdetails").hide();
        }else{
             $(".shippingdetails").show();
        }   

</script>
