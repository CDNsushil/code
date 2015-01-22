<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$refundStage3_2 = array(
  'name'=>'refundStage3_2',
  'id'=>'refundStage3_2'
);

$madifyButton   =   array(
  'name'        =>  'madify',
  'id'          =>  'madify',
  'content'     =>  $this->lang->line('packpayment_billing_modify'),
  'class'       =>  'fr  back_click_1 bg_F0F0F0 bdr_b1b1b1',
  'type'        =>  'button',
);

$paymentTermCondition = array(
  'name'    =>  'paymentTermCondition',
  'id'      =>  'paymentTermCondition',
  'value'   =>  '1',
  'type'    =>  'checkbox',
  'class'   => 'ez-hide width_auto',
);

// get buyer setting data
$firstNameValue       =   (!empty($orderBillingDetails->billing_firstName))?$orderBillingDetails->billing_firstName:"";
$lastNameValue        =   (!empty($orderBillingDetails->billing_lastName))?$orderBillingDetails->billing_lastName:"";
$companyNameValue     =   (!empty($orderBillingDetails->billing_companyName))?$orderBillingDetails->billing_companyName:"";
$addressLine1Value    =   (!empty($orderBillingDetails->billing_address1))?$orderBillingDetails->billing_address1:"";
$addressLine2Value    =   (!empty($orderBillingDetails->billing_address2))?$orderBillingDetails->billing_address2:"";
$townOrCityValue      =   (!empty($orderBillingDetails->billing_city))?$orderBillingDetails->billing_city:"";
$stateValue           =   (!empty($orderBillingDetails->billing_state))?getstateName($orderBillingDetails->billing_state):"";
$countryValue         =   (!empty($orderBillingDetails->billing_country))?getCountry($orderBillingDetails->billing_country):"";
$zipCodeValue         =   (!empty($orderBillingDetails->billing_zip))?$orderBillingDetails->billing_zip:"";
$phoneNumberValue     =   (!empty($orderBillingDetails->billing_phone))?$orderBillingDetails->billing_phone:"";
$emailValue           =   (!empty($orderBillingDetails->billing_email))?$orderBillingDetails->billing_email:"";
?>
<!--  content wrap  start end -->
<?php echo form_open($this->uri->uri_string(),$refundStage3_2); ?>
<div class="newlanding_container">
  <div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
       <?php $this->load->view('common_view/refund_stage_menus') ?>
      <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
          <div class="TabbedPanelsContent TabbedPanelsContentVisible">
             <div id="TabbedPanels5" class="TabbedPanels tab_setting">
               <?php $this->load->view('common_view/refund_stage_sub_menus') ?>
                 
                    <div class="TabbedPanelsContentGroup ">
                        <div class="TabbedPanelsContent width635 TabbedPanelsContentVisible">
                          <h3> Purchase Summary </h3>
                          <ul class="total  purcharse clearb mt40" >
                             <?php 
                                //------------selected container price-------------------//
                                // default price of container price 
                                $totalPaidPrice = 0;
                                $totalPaidPrice =  multiarraysum($selectedContainerList,'totalPrice');
                                //calculate percent
                                $vatPercent      =  $this->config->item('package_vat_percent');
                                $VatPrice       = (($totalPaidPrice*$vatPercent)/100);
                              ?>
                              
                             <li class="clearb space_1 BB_dadada" >
                                <span class="display_cell p_head"> <span class="fs16 font_bold minwidth_165 "><?php echo $this->lang->line('pack_payment_with_membership_donwgrade'); ?></span> 
                               </span>
                                <span class="price"> <?php echo '€ '.number_format($totalPaidPrice,2); ?> </span> 
                             </li>
                           
                             <li class="clearb  space_1 " >
                                <span class="p_head pr36 text_alignR "> <?php echo $this->lang->line('packpayment_vat_15_pece'); ?> </span>
                                <span class="price "> <?php echo '€ '.number_format($VatPrice,2); ?>  </span> 
                             </li>
                             
                             <li class="clearb BT_dadada" >
                                <span class="red p_head font_bold pr36 text_alignR "> <?php echo $this->lang->line('packpayment_member_total'); ?> </span>
                                <span class="price red font_bold">
                                  <?php 
                                     $totalPrice    =  $totalPaidPrice +  $VatPrice;
                                     echo '€ '.number_format($totalPrice,2); 
                                  ?> 
                                 </span> 
                             </li>
                          </ul>
                          <div class="sap_65"></div>
                          <div class="bill_detail clearb color_666 ">
                             <span class="fl billcontent">
                                <h4 class="fs21 fl red clearb "> Billing Details</h4>
                                <div class="sap_15"></div>
                                <p><?php echo $firstNameValue.' '.$lastNameValue ?></p>
                                <p><?php echo $addressLine1Value;?><?php echo (!empty($addressLine2Value))?', '.$addressLine2Value:'';?></p>
                                <p><?php echo $townOrCityValue;?>, <?php echo $stateValue;?></p>
                                <p><?php echo $zipCodeValue;?></p>
                                <p><?php echo $countryValue;?></p>
                                <p><?php echo $emailValue;?></p>
                                <p><?php echo $phoneNumberValue;?></p>
                             </span>
                            
                             <div class="sap_30"></div>
                             <p>
                                 <a href="<?php echo base_url('package/refundbillingdetails'); ?>">
                                    <?php echo form_button($madifyButton); ?>
                                  </a>
                             </p>
                          </div>
                          <div class=" sap_50"></div>
                          <div class="bdr_non clearb ml2 fl">
                             <label class="defaultP ml0">
                              <?php  echo form_input($paymentTermCondition); ?> 
                             I acknowledge to have read, understood and agreed the <a  href="<?php echo base_url(lang().'/cms/termsncondition'); ?>" target="_blank" >Terms &amp; Conditions</a> of the Toadsquare
                             website. </label>
                          </div>
                          <div class="validation_error dn pt_15 pl30" id="payment_term_error" >
                            <?php echo $this->lang->line('packstage2_error_messag'); ?>
                          </div>
                          
                          <div class="clearb download_pdf mt15 fl pl30">
                               <span class="fl pr10">Download the Terms & Conditions in PDF.</span>
                               <ul class="fl font_bold">
                                  <li>
                                     <a href="<?php echo base_url('images/Terms and Conditions_18.04.2013.pdf'); ?>" target="_blank">English</a>
                                  </li>
                                  <li>
                                     <a href="javascript:void(0)">Francias</a>
                                  </li>
                                  <li>
                                     <a href="javascript:void(0)">Deutcsh</a>
                                  </li>
                               </ul>
                            </div>
                           
                          <?php  if($totalPrice >0){ ?>   
                              <div class=" sap_25"></div>
                              <ul class="fl lineH20 pt3 fs12 ul_wrap ml36">
                                 <li class="  mt3 "> <span class="fl">Pay Securely using PayPal or Credit Card </span><img src="<?php echo $imgPath; ?>paypal_img.png" alt="a" class=" fl display_inline pl15 lineH24" /></li>
                              </ul>
                          <?php } ?>
                          
                            <?php 
                              $data['backUrl']    =  base_url('package/refundbillingdetails');
                              $data['cancelUrl']  =  base_url('package/information'); // set cancel url
                              if($totalPrice >0){
                                  $data['isPayNowButton']      =     TRUE; # set pay now button show
                              }
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
   $("#refundStage3_2").submit(function(){
     
       var getChkStatus= $('#paymentTermCondition').is(":checked");
       if(getChkStatus){
          $('#payment_term_error').hide();
          window.location.href="<?php echo base_url(lang().'/package/refundcalculate') ?>";		
       }else{
         $('#payment_term_error').show();
       }
     return false;
   });

</script>
