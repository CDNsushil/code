<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$firstNameValue       =   (!empty($orderBillingDetails->billing_firstName))?$orderBillingDetails->billing_firstName:"";
$lastNameValue        =   (!empty($orderBillingDetails->billing_lastName))?$orderBillingDetails->billing_lastName:"";
$companyNameValue     =   (!empty($orderBillingDetails->billing_companyName))?$orderBillingDetails->billing_companyName:"";
$addressLine1Value    =   (!empty($orderBillingDetails->billing_address1))?$orderBillingDetails->billing_address1:"";
$addressLine2Value    =   (!empty($orderBillingDetails->billing_address2))?$orderBillingDetails->billing_address2:"";
$townOrCityValue      =   (!empty($orderBillingDetails->billing_city))?$orderBillingDetails->billing_city:"";
$stateValue           =   (!empty($orderBillingDetails->billing_state))?$orderBillingDetails->billing_state:"";
$countryValue         =   (!empty($orderBillingDetails->billing_country))?$orderBillingDetails->billing_country:"";
$zipCodeValue         =   (!empty($orderBillingDetails->billing_zip))?$orderBillingDetails->billing_zip:"";
$phoneNumberValue     =   (!empty($orderBillingDetails->billing_phone))?$orderBillingDetails->billing_phone:"";
$emailValue           =   (!empty($orderBillingDetails->billing_email))?$orderBillingDetails->billing_email:"";

$refundStage3_1 = array(
  'name'=>'refundStage3_1',
  'id'=>'refundStage3_1'
);

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


?>
<!--  content wrap  start end -->
<?php echo form_open($this->uri->uri_string(),$refundStage3_1); ?>
<div class="newlanding_container">
	<div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
       <?php $this->load->view('common_view/refund_stage_menus') ?>
      <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
          <div class="TabbedPanelsContent TabbedPanelsContentVisible">
             <div id="TabbedPanels5" class="TabbedPanels tab_setting">
               <?php $this->load->view('common_view/refund_stage_sub_menus') ?>
                <div class="TabbedPanelsContentGroup ">
                   <div class="TabbedPanelsContent TabbedPanelsContentVisible">
                      <div class="wra_head clearb">
                         <h3 class="red   fs21 fnt_mouse bb_aeaeae"> Billing Details </h3>
                         <div class="sap_30"></div>
                         <ul class=" billing_form form2" >
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
                         <ul class="pt20">
                            <li class="icon_2"> This setting is stored in your <a href="<?php echo base_url(lang().'/dashboard/globalsettings/3'); ?>" target="_blank">Buyer Settings</a>. Your Toadsquaremenu > menu <a  href="<?php echo base_url(lang().'/dashboard/globalsettings'); ?>" target="_blank">Global Setttings.</a></li>
                         </ul>
                      </div>
                        <?php 
                          $data['cancelUrl']  =  base_url('package/information'); // set cancel url
                          $data['backUrl'] = base_url('package/refundstagetwo');
                          $this->load->view('common_view/common_buttons',$data);
                        ?>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>  
<!--  content wrap  end -->

<script>
  /**
   * @Description: This function for billing form validation
   */
  $('#firstName').focus();
  $("#refundStage3_1").validate({
      
    rules: {
        "zipCode": {
        required: true,
        //number: true,
        },
        "phoneNumber": {
        number: true,
        },
    },
    messages: {
        "zipCode": {
        number: "Zip Code must contain only numbers."
        },
        "phoneNumber": {
        number: "Phone Number must contain only numbers."
        }
    }, 
    
    submitHandler: function() {
      var formPostUrl = "/package/refundbillingdetailspost";
      var formData =$("#refundStage3_1").serialize();
      $.ajax({
      type: 'POST',
      url : baseUrl + language + formPostUrl,
      dataType :'json',
      data : formData,
      beforeSend:function(){
        $(".new_verion_loader").loaderShow();
      },
      complete:function(){
        
      },
      success:function(data){
        redirectToPage(data.redirecturl);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $("#successMsg").html('');
      }
      });
    }
  });	

</script>
